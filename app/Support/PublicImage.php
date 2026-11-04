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

        // Build from the current request host rather than APP_URL, so a misconfigured
        // APP_URL (e.g. missing "https://") can't produce broken relative URLs.
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return is_file(public_path($path)) ? asset($path) : null;
    }

    public static function placeholder(): string
    {
        return asset('frontend/products/placeholders/no-image.svg');
    }
}
