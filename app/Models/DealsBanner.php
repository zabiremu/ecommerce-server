<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealsBanner extends Model
{
    protected $table = 'deals_banner';

    protected $fillable = [
        'emoji',
        'title',
        'title_highlight',
        'description',
        'button_text',
        'button_link',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Limited Time',
            'status' => true,
        ]);
    }
}
