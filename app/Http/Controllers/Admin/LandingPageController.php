<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /** Available layout presets (Default + named skins). */
    public const LAYOUTS = [
        'default' => 'Default',
        'one'     => 'One',
        'two'     => 'Two',
        'three'   => 'Three',
        'four'    => 'Four',
        'five'    => 'Five',
        'six'     => 'Six',
    ];

    // ── Landings list ─────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $search = trim((string) $request->get('s', ''));

        $landings = ProductLandingPage::with('product')
            ->when($search, function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                  ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('Admin.landing.index', compact('landings', 'search'));
    }

    public function create()
    {
        // Only products that don't already have a landing page (1:1 unique).
        $products = Product::whereDoesntHave('landingPage')
            ->orderBy('name')
            ->get(['id', 'name', 'selling_price', 'thumbnail']);

        $layouts = self::LAYOUTS;

        return view('Admin.landing.create', compact('products', 'layouts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id|unique:product_landing_pages,product_id',
            'slug'       => 'required|string|max:255|regex:/^[a-z0-9\-]+$/|unique:product_landing_pages,slug',
            'layout'     => 'required|string|in:' . implode(',', array_keys(self::LAYOUTS)),
        ]);

        $product = Product::findOrFail($data['product_id']);

        $landing = ProductLandingPage::create([
            'product_id'             => $product->id,
            'slug'                   => $data['slug'],
            'layout'                 => $data['layout'],
            'is_active'              => false,
            'blocks'                 => [],
            'shipping_inside_dhaka'  => 0,
            'shipping_outside_dhaka' => 80,
            'enable_online_payment'  => false,
            'cta_text'               => 'অর্ডার করতে চাই',
        ]);

        return redirect()
            ->route('admin.products.landing.edit', $product)
            ->with('success', 'Landing page created. Add your blocks below.');
    }

    public function destroy(ProductLandingPage $landing)
    {
        // Clean up any uploaded block images.
        foreach (($landing->blocks ?? []) as $block) {
            if (($block['type'] ?? '') === 'image' && !empty($block['path'])) {
                Storage::disk('public')->delete($block['path']);
            }
        }

        $landing->delete();

        return back()->with('success', 'Landing page deleted.');
    }

    // ── Block builder (per product) ───────────────────────────────────────

    public function edit(Product $product)
    {
        $landing = $product->landingPage ?? new ProductLandingPage([
            'slug'                   => Str::slug($product->name) . '-lp',
            'is_active'              => false,
            'layout'                 => 'default',
            'blocks'                 => [],
            'shipping_inside_dhaka'  => 0,
            'shipping_outside_dhaka' => 80,
            'enable_online_payment'  => false,
            'cta_text'               => 'অর্ডার করতে চাই',
        ]);

        $layouts = self::LAYOUTS;

        return view('Admin.product.landing', compact('product', 'landing', 'layouts'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'slug'                   => 'required|string|max:255|regex:/^[a-z0-9\-]+$/',
            'is_active'              => 'boolean',
            'layout'                 => 'required|string|in:' . implode(',', array_keys(self::LAYOUTS)),
            'shipping_inside_dhaka'  => 'nullable|numeric|min:0',
            'shipping_outside_dhaka' => 'nullable|numeric|min:0',
            'enable_online_payment'  => 'boolean',
            'footer_text'            => 'nullable|string|max:255',
            'hero_subheading'        => 'nullable|string|max:500',
            'cta_text'               => 'nullable|string|max:100',
            'meta_title'             => 'nullable|string|max:255',
            'meta_description'       => 'nullable|string|max:500',
        ]);

        // Ensure slug is unique (exclude this product's own landing page)
        $existingId = optional($product->landingPage)->id;
        $slugTaken  = ProductLandingPage::where('slug', $data['slug'])
            ->when($existingId, fn ($q) => $q->where('id', '!=', $existingId))
            ->exists();

        if ($slugTaken) {
            return back()->withErrors(['slug' => 'This slug is already taken by another landing page.'])->withInput();
        }

        $data['is_active']             = $request->boolean('is_active');
        $data['enable_online_payment'] = $request->boolean('enable_online_payment');
        $data['shipping_inside_dhaka'] = (float) ($data['shipping_inside_dhaka'] ?? 0);
        $data['shipping_outside_dhaka']= (float) ($data['shipping_outside_dhaka'] ?? 0);
        $data['cta_text']              = $data['cta_text'] ?: 'অর্ডার করতে চাই';
        $data['blocks']                = $this->normalizeBlocks($request);

        $product->landingPage()->updateOrCreate(
            ['product_id' => $product->id],
            array_merge($data, ['product_id' => $product->id])
        );

        return back()->with('success', 'Landing page saved successfully.');
    }

    /**
     * Build a clean, ordered blocks array from the submitted form, handling
     * per-block image uploads and preserving existing image paths.
     */
    private function normalizeBlocks(Request $request): array
    {
        $blocks = [];

        foreach ($request->input('blocks', []) as $i => $b) {
            $type = $b['type'] ?? null;

            switch ($type) {
                case 'youtube':
                    $blocks[] = [
                        'type'        => 'youtube',
                        'url'         => trim($b['url'] ?? ''),
                        'title'       => trim($b['title'] ?? ''),
                        'description' => $b['description'] ?? '',
                    ];
                    break;

                case 'rounded_heading':
                    $style = $b['style'] ?? 'green';
                    $blocks[] = [
                        'type'       => 'rounded_heading',
                        'heading'    => trim($b['heading'] ?? ''),
                        'subheading' => trim($b['subheading'] ?? ''),
                        'style'      => in_array($style, ['green', 'dark'], true) ? $style : 'green',
                    ];
                    break;

                case 'richtext':
                    $blocks[] = [
                        'type' => 'richtext',
                        'html' => $b['html'] ?? '',
                    ];
                    break;

                case 'image':
                    $path = $b['path'] ?? '';
                    $file = $request->file("blocks.$i.image_file");
                    if ($file) {
                        $path = $file->store('landings', 'public');
                    }
                    $blocks[] = [
                        'type'    => 'image',
                        'path'    => $path,
                        'caption' => trim($b['caption'] ?? ''),
                    ];
                    break;

                case 'video_thumbs':
                    $items = [];
                    foreach (($b['items'] ?? []) as $it) {
                        $url = trim($it['url'] ?? '');
                        if ($url === '') continue;
                        $items[] = ['url' => $url, 'label' => trim($it['label'] ?? '')];
                    }
                    $blocks[] = ['type' => 'video_thumbs', 'items' => $items];
                    break;

                case 'price_offer':
                    $blocks[] = [
                        'type'      => 'price_offer',
                        'label'     => trim($b['label'] ?? ''),
                        'old_price' => trim($b['old_price'] ?? ''),
                        'new_price' => trim($b['new_price'] ?? ''),
                        'note'      => trim($b['note'] ?? ''),
                    ];
                    break;
            }
        }

        return $blocks;
    }
}
