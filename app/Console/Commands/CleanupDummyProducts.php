<?php

namespace App\Console\Commands;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One-off cleanup for leftover data from database/seeders/DummyProductSeeder.php,
 * which was run manually against the database at some point but is not wired into
 * DatabaseSeeder.php. Its products (SKU prefix "DUM-") ended up live in the real
 * catalog, showing up as ghost/orphan items in carts.
 */
class CleanupDummyProducts extends Command
{
    protected $signature = 'app:cleanup-dummy-products
        {--apply : Actually delete data. Without this flag the command only reports what it would do.}
        {--force : Skip the confirmation prompt when used together with --apply.}';

    protected $description = 'Remove dummy products (SKU starting with DUM-) seeded by DummyProductSeeder, and scrub obvious test reviews';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');

        $dummyProducts = Product::where('sku', 'like', 'DUM-%')->get();

        if ($dummyProducts->isEmpty()) {
            $this->info('No dummy products found (no SKU starting with DUM-). Nothing to do.');
        } else {
            $this->line("Found {$dummyProducts->count()} product(s) with a DUM- SKU.");

            $orderedProductIds = OrderItem::whereIn('product_id', $dummyProducts->pluck('id'))
                ->distinct()
                ->pluck('product_id')
                ->all();

            $toDelete = $dummyProducts->reject(fn (Product $p) => \in_array($p->id, $orderedProductIds, true));
            $toSkip = $dummyProducts->whereIn('id', $orderedProductIds);

            if ($toSkip->isNotEmpty()) {
                $this->warn("Skipping {$toSkip->count()} dummy product(s) that have real order_items against them (will not delete, to avoid touching order history):");
                foreach ($toSkip as $p) {
                    $orderIds = OrderItem::where('product_id', $p->id)->pluck('order_id')->unique()->implode(', ');
                    $this->line("  - #{$p->id} {$p->name} ({$p->sku}) — order id(s): {$orderIds}");
                }
            }

            $this->line("{$toDelete->count()} dummy product(s) are safe to delete (no orders reference them).");

            if (! $apply) {
                $this->newLine();
                $this->comment('Dry run only. Re-run with --apply to actually delete the products above.');
                foreach ($toDelete as $p) {
                    $this->line("  would delete: #{$p->id} {$p->name} ({$p->sku})");
                }
            } else {
                if (! $this->option('force') && ! $this->confirm("Delete {$toDelete->count()} dummy product(s) and their variants/reviews now?")) {
                    $this->comment('Aborted, nothing deleted.');
                    return self::SUCCESS;
                }

                $deletedPaths = [];

                DB::transaction(function () use ($toDelete, &$deletedPaths) {
                    foreach ($toDelete as $product) {
                        if ($product->thumbnail) {
                            $deletedPaths[] = $product->thumbnail;
                        }
                        foreach ((array) $product->gallery as $item) {
                            $path = \is_array($item) ? ($item['path'] ?? null) : $item;
                            if ($path) {
                                $deletedPaths[] = $path;
                            }
                        }

                        // Variants and reviews cascade-delete at the DB level (FK onDelete cascade);
                        // order_items / cart_items referencing this product have their product_id nulled
                        // but keep their own denormalized name/sku/price, so order history is unaffected.
                        $product->delete();
                    }
                });

                $this->info("Deleted {$toDelete->count()} dummy product(s).");

                // Dummy images are copied into storage/app/public/products/dummy/ and reused across
                // multiple dummy products, so only remove a file once no remaining product references it.
                $deletedPaths = array_unique(array_filter($deletedPaths, fn ($p) => str_starts_with($p, 'products/dummy/')));
                $removedFiles = 0;
                foreach ($deletedPaths as $path) {
                    $stillUsed = Product::where('thumbnail', $path)
                        ->orWhere('gallery', 'like', '%' . $path . '%')
                        ->exists();
                    if (! $stillUsed && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                        $removedFiles++;
                    }
                }
                $this->line("Removed {$removedFiles} now-unreferenced dummy image file(s) from storage.");
            }
        }

        $this->newLine();
        $this->cleanupTestReviews($apply);

        return self::SUCCESS;
    }

    private function cleanupTestReviews(bool $apply): void
    {
        $testReviews = ProductReview::where(function ($q) {
            $q->where('name', 'like', 'Guest Tester%')
                ->orWhere('email', 'like', 'guest%@example.com');
        })->get();

        if ($testReviews->isEmpty()) {
            $this->info('No test reviews found.');
            return;
        }

        $this->line("Found {$testReviews->count()} test review(s):");
        foreach ($testReviews as $r) {
            $this->line("  - #{$r->id} product #{$r->product_id} — {$r->name} <{$r->email}>: \"" . Str::limit($r->comment, 50) . '"');
        }

        if (! $apply) {
            $this->comment('Dry run only. Re-run with --apply to delete the test reviews above.');
            return;
        }

        ProductReview::whereIn('id', $testReviews->pluck('id'))->delete();
        $this->info("Deleted {$testReviews->count()} test review(s).");
    }
}
