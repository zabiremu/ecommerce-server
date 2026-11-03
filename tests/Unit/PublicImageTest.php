<?php

namespace Tests\Unit;

use App\Support\PublicImage;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicImageTest extends TestCase
{
    public function test_it_only_returns_urls_for_existing_local_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/available.jpg', 'image');

        $this->assertSame(
            Storage::disk('public')->url('products/available.jpg'),
            PublicImage::url('products/available.jpg')
        );
        $this->assertNull(PublicImage::url('products/missing.jpg'));
    }

    public function test_it_preserves_external_urls_and_existing_public_assets(): void
    {
        $this->assertSame('https://example.test/image.jpg', PublicImage::url('https://example.test/image.jpg'));
        $this->assertSame(
            asset('frontend/products/placeholders/no-image.svg'),
            PublicImage::url('frontend/products/placeholders/no-image.svg')
        );
    }
}
