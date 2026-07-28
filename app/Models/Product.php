<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'unit_id',
        'supplier_id',
        'type',
        'sku',
        'barcode',
        'purchase_price',
        'selling_price',
        'sale_price',
        'stock',
        'alert_quantity',
        'digital_file',
        'description',
        'short_description',
        'long_description',
        'thumbnail',
        'gallery',
        'publish_status',
        'special_sections',
    ];

    public const PUBLISH_STATUSES = ['draft', 'pending', 'published'];

    /** Admin-curated homepage badges. Distinct from the auto-computed
     *  "Best Sellers" section and "New Arrival" ribbon — see the
     *  add_special_sections_to_products_table migration. */
    public const SPECIAL_SECTIONS = [
        'new-arrival'        => ['label' => 'New Arrival', 'emoji' => '🔥'],
        'best-seller'        => ['label' => 'Best Seller', 'emoji' => '⭐'],
        'premium-collection' => ['label' => 'Premium Collection', 'emoji' => '💎'],
        'flash-sale'         => ['label' => 'Flash Sale', 'emoji' => '💥'],
        'combo-offer'        => ['label' => 'Combo Offer', 'emoji' => '🎁'],
        'restock'            => ['label' => 'Restock', 'emoji' => '🆕'],
        'clearance'          => ['label' => 'Clearance', 'emoji' => '🏷️'],
    ];

    protected function casts(): array
    {
        return [
            'type' => 'string',
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock' => 'decimal:2',
            'alert_quantity' => 'decimal:2',
            'gallery' => 'array',
            'special_sections' => 'array',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('publish_status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('publish_status', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('publish_status', 'pending');
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function landingPage()
    {
        return $this->hasOne(ProductLandingPage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
