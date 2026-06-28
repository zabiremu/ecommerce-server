<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    protected static ?array $cache = null;

    public static function all_indexed(): array
    {
        if (static::$cache === null) {
            static::$cache = static::query()->pluck('value', 'key')->all();
        }
        return static::$cache;
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::all_indexed();
        $val = $all[$key] ?? null;
        return ($val === null || $val === '') ? $default : $val;
    }

    public static function flushCache(): void
    {
        static::$cache = null;
    }
}
