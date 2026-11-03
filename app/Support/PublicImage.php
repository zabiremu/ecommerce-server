<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PublicImage
{
    public static function url(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (preg_match('/^(https?:)?\/\//i', $path) || str_starts_with($path, 'data:image/')) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return is_file(public_path($path)) ? asset($path) : null;
    }

    public static function placeholder(): string
    {
        return asset('frontend/products/placeholders/no-image.svg');
    }
}
