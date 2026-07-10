<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status', 'all');
        $search = trim((string) $request->query('s', ''));
        $categoryId = $request->query('category');

        $query = Product::with('category', 'brand', 'unit', 'supplier', 'landingPage');

        if (in_array($filter, Product::PUBLISH_STATUSES, true)) {
            $query->where('publish_status', $filter);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $counts = [
            'all' => Product::count(),
            'published' => Product::published()->count(),
            'pending' => Product::pending()->count(),
            'draft' => Product::draft()->count(),
        ];

        $categories = Category::orderBy('name')->get();

        return view('Admin.product.index', compact('products', 'counts', 'filter', 'search', 'categoryId', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();
        $units = Unit::where('status', true)->orderBy('name')->get();
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $publishStatuses = Product::PUBLISH_STATUSES;
        return view('Admin.product.create', compact('categories', 'brands', 'units', 'suppliers', 'publishStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'nullable|exists:units,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type' => 'required|in:physical,digital',
            'sku' => 'required|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:selling_price',
            'alert_quantity' => 'nullable|numeric|min:0',
            'digital_file' => 'nullable|required_if:type,digital|file|mimes:zip,pdf,mp3,mp4,avi,jpg,png|max:102400',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_items' => 'nullable|array',
            'gallery_items.*.file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_items.*.color' => 'nullable|string|max:50',
            'variants' => 'nullable|array',
            'variants.*.name' => 'nullable|string|max:255',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|numeric|min:0',
            'variants.*.sku' => 'nullable|string|max:100',
            'publish_status' => 'nullable|in:draft,pending,published',
        ]);

        // Note: new physical products always start at 0 stock (set via GRN), so
        // variant-vs-available-stock validation is only enforced on update().

        $data = $request->except(['digital_file', 'thumbnail', 'gallery_items', 'variants', 'stock']);

        if (empty($data['publish_status'])) {
            $data['publish_status'] = 'draft';
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (empty($data['barcode'])) {
            $data['barcode'] = $data['sku'];
        }

        if ($request->type === 'digital') {
            $data['stock'] = null;
            $data['alert_quantity'] = null;
            if ($request->hasFile('digital_file')) {
                $data['digital_file'] = $request->file('digital_file')->store('products/digital', 'public');
            }
        } else {
            // Physical products start with 0 stock — increased via GRN.
            $data['stock'] = 0;
            $data['digital_file'] = null;
        }

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail');
            $thumbName = 'thumb_' . uniqid() . '.webp';
            $thumbPath = 'products/thumbnails/' . $thumbName;
            $image = $manager->read($thumb);
            $image->resize(300, 300);
            Storage::disk('public')->put($thumbPath, $image->toWebp(85));
            $data['thumbnail'] = $thumbPath;
        }

        if ($request->has('gallery_items')) {
            $gallery = [];
            foreach ($request->gallery_items as $item) {
                $galleryEntry = ['color' => $item['color'] ?? null, 'path' => null];
                if (isset($item['file']) && $item['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $galName = 'gal_' . uniqid() . '.webp';
                    $galPath = 'products/gallery/' . $galName;
                    $image = $manager->read($item['file']);
                    $image->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    Storage::disk('public')->put($galPath, $image->toWebp(85));
                    $galleryEntry['path'] = $galPath;
                }
                if ($galleryEntry['path']) {
                    $gallery[] = $galleryEntry;
                }
            }
            $data['gallery'] = $gallery;
        }

        $product = Product::create($data);

        if ($request->has('variants')) {
            foreach ($request->variants as $i => $v) {
                if (empty($v['name']) && empty($v['size']) && empty($v['color'])) {
                    continue;
                }
                $product->variants()->create([
                    'name' => $v['name'] ?? null,
                    'size' => $v['size'] ?? null,
                    'color' => $v['color'] ?? null,
                    'price' => $v['price'] ?? null,
                    'stock' => $v['stock'] ?? null,
                    'sku' => $v['sku'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->orderBy('name')->get();
        $brands = Brand::where('status', true)->orderBy('name')->get();
        $units = Unit::where('status', true)->orderBy('name')->get();
        $suppliers = Supplier::where('status', true)->orderBy('name')->get();
        $publishStatuses = Product::PUBLISH_STATUSES;
        $product->load('variants');
        return view('Admin.product.edit', compact('product', 'categories', 'brands', 'units', 'suppliers', 'publishStatuses'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'unit_id' => 'nullable|exists:units,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type' => 'required|in:physical,digital',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:selling_price',
            'alert_quantity' => 'nullable|numeric|min:0',
            'digital_file' => 'nullable|file|mimes:zip,pdf,mp3,mp4,avi,jpg,png|max:102400',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'long_description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_items' => 'nullable|array',
            'gallery_items.*.file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_items.*.color' => 'nullable|string|max:50',
            'variants' => 'nullable|array',
            'variants.*.name' => 'nullable|string|max:255',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|numeric|min:0',
            'variants.*.sku' => 'nullable|string|max:100',
            'publish_status' => 'nullable|in:draft,pending,published',
        ]);

        if ($request->type === 'physical') {
            $available = (float) $product->stock;
            $total = 0;
            foreach ($request->input('variants', []) as $v) {
                if (empty($v['name']) && empty($v['size']) && empty($v['color'])) {
                    continue;
                }
                $total += (float) ($v['stock'] ?? 0);
            }
            if ($total > $available) {
                return back()->withInput()->withErrors([
                    'variants' => "Total variant stock ({$total}) exceeds available product stock ({$available}).",
                ]);
            }
        }

        // Never let edit form touch stock — it's GRN-controlled.
        $data = $request->except(['digital_file', 'thumbnail', 'gallery_items', 'variants', 'stock']);

        if (empty($data['publish_status'])) {
            $data['publish_status'] = $product->publish_status ?? 'draft';
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if (empty($data['barcode'])) {
            $data['barcode'] = $data['sku'];
        }

        if ($request->type === 'digital') {
            $data['stock'] = null;
            $data['alert_quantity'] = null;
            if ($request->hasFile('digital_file')) {
                if ($product->digital_file) {
                    Storage::disk('public')->delete($product->digital_file);
                }
                $data['digital_file'] = $request->file('digital_file')->store('products/digital', 'public');
            }
        } else {
            if ($product->digital_file) {
                Storage::disk('public')->delete($product->digital_file);
            }
            $data['digital_file'] = null;
        }

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $thumb = $request->file('thumbnail');
            $thumbName = 'thumb_' . uniqid() . '.webp';
            $thumbPath = 'products/thumbnails/' . $thumbName;
            $image = $manager->read($thumb);
            $image->resize(300, 300);
            Storage::disk('public')->put($thumbPath, $image->toWebp(85));
            $data['thumbnail'] = $thumbPath;
        }

        $existingGallery = $product->gallery ?? [];
        if (!is_array($existingGallery)) {
            $existingGallery = [];
        }

        if ($request->has('gallery_colors')) {
            foreach ($existingGallery as $gi => &$ge) {
                if (isset($request->gallery_colors[$gi])) {
                    $ge['color'] = $request->gallery_colors[$gi];
                }
            }
        }

        if ($request->has('gallery_items')) {
            foreach ($request->gallery_items as $item) {
                if (isset($item['file']) && $item['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $galName = 'gal_' . uniqid() . '.webp';
                    $galPath = 'products/gallery/' . $galName;
                    $image = $manager->read($item['file']);
                    $image->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    Storage::disk('public')->put($galPath, $image->toWebp(85));
                    $existingGallery[] = [
                        'path' => $galPath,
                        'color' => $item['color'] ?? null,
                    ];
                }
            }
        }
        $data['gallery'] = $existingGallery;

        $product->update($data);

        if ($request->has('variants')) {
            $keepIds = [];
            foreach ($request->variants as $i => $v) {
                if (empty($v['name']) && empty($v['size']) && empty($v['color']) && empty($v['id'])) {
                    continue;
                }
                $variantData = [
                    'name' => $v['name'] ?? null,
                    'size' => $v['size'] ?? null,
                    'color' => $v['color'] ?? null,
                    'price' => $v['price'] ?? null,
                    'stock' => $v['stock'] ?? null,
                    'sku' => $v['sku'] ?? null,
                    'sort_order' => $i,
                ];

                if (!empty($v['id'])) {
                    $variant = ProductVariant::find($v['id']);
                    if ($variant && $variant->product_id === $product->id) {
                        $variant->update($variantData);
                        $keepIds[] = $variant->id;
                    }
                } else {
                    $variant = $product->variants()->create($variantData);
                    $keepIds[] = $variant->id;
                }
            }
            $product->variants()->whereNotIn('id', $keepIds)->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->digital_file) {
            Storage::disk('public')->delete($product->digital_file);
        }
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        if ($product->gallery) {
            foreach ($product->gallery as $item) {
                $path = is_array($item) ? ($item['path'] ?? null) : $item;
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        $product->variants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function setStatus(Request $request, Product $product)
    {
        $request->validate(['publish_status' => 'required|in:draft,pending,published']);
        $product->update(['publish_status' => $request->publish_status]);
        return back()->with('success', 'Product status updated.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:draft,pending,published,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:products,id',
        ]);

        $ids = $request->ids;

        if ($request->action === 'delete') {
            $products = Product::with('variants')->whereIn('id', $ids)->get();
            foreach ($products as $p) {
                if ($p->digital_file) Storage::disk('public')->delete($p->digital_file);
                if ($p->thumbnail) Storage::disk('public')->delete($p->thumbnail);
                if ($p->gallery) {
                    foreach ($p->gallery as $item) {
                        $path = is_array($item) ? ($item['path'] ?? null) : $item;
                        if ($path) Storage::disk('public')->delete($path);
                    }
                }
                $p->variants()->delete();
                $p->delete();
            }
            return back()->with('success', count($ids) . ' product(s) deleted.');
        }

        Product::whereIn('id', $ids)->update(['publish_status' => $request->action]);
        return back()->with('success', count($ids) . ' product(s) updated to ' . $request->action . '.');
    }

    public function barcodeImage($code)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 50);

        return response($barcode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="barcode.png"',
        ]);
    }

    public function printBarcodes(Request $request)
    {
        $selectedProduct = null;
        $qty = max(1, min(200, (int) $request->query('qty', 1)));

        if ($request->filled('product')) {
            $selectedProduct = Product::find($request->query('product'));
            $products = $selectedProduct
                ? collect(array_fill(0, $qty, $selectedProduct))
                : collect();
        } else {
            $products = Product::published()->orderBy('name')->get();
        }

        $allProducts = Product::orderBy('name')->get(['id', 'name']);

        return view('Admin.product.barcodes', compact('products', 'allProducts', 'selectedProduct', 'qty'));
    }

    public function deleteGalleryImage(Product $product, $index)
    {
        $gallery = $product->gallery ?? [];
        if (isset($gallery[$index])) {
            $path = is_array($gallery[$index]) ? ($gallery[$index]['path'] ?? null) : $gallery[$index];
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            unset($gallery[$index]);
            $product->update(['gallery' => array_values($gallery)]);
        }
        return back()->with('success', 'Gallery image removed.');
    }

    public function updateGalleryColor(Request $request, Product $product, $index)
    {
        $request->validate(['color' => 'nullable|string|max:50']);
        $gallery = $product->gallery ?? [];
        if (isset($gallery[$index])) {
            if (is_array($gallery[$index])) {
                $gallery[$index]['color'] = $request->color;
            } else {
                $gallery[$index] = ['path' => $gallery[$index], 'color' => $request->color];
            }
            $product->update(['gallery' => array_values($gallery)]);
        }
        return back()->with('success', 'Gallery color updated.');
    }
}
