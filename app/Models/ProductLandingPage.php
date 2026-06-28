<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLandingPage extends Model
{
    protected $fillable = [
        'product_id',
        'slug',
        'is_active',
        'layout',
        'blocks',
        'shipping_inside_dhaka',
        'shipping_outside_dhaka',
        'enable_online_payment',
        'footer_text',
        'hero_heading',
        'hero_subheading',
        'cta_text',
        'show_gallery',
        'show_price',
        'show_short_desc',
        'show_long_desc',
        'custom_content',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active'             => 'boolean',
            'blocks'                => 'array',
            'shipping_inside_dhaka' => 'decimal:2',
            'shipping_outside_dhaka'=> 'decimal:2',
            'enable_online_payment' => 'boolean',
            'show_gallery'          => 'boolean',
            'show_price'            => 'boolean',
            'show_short_desc'       => 'boolean',
            'show_long_desc'        => 'boolean',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** Extract an 11-char YouTube video id from a full URL or bare id. */
    public static function youtubeId(?string $url): ?string
    {
        if (!$url) return null;
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/|v/))([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }
        if (preg_match('~^[A-Za-z0-9_-]{11}$~', $url)) {
            return $url;
        }
        return null;
    }
}
