<?php

namespace Tests\Feature;

use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    use CreatesProducts;

    public function test_logged_in_customer_can_submit_a_review(): void
    {
        $product = $this->makeProduct();
        $user = User::create(['name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'secret123']);

        $response = $this->actingAs($user, 'web')->postJson('/product-reviews', [
            'product_id' => $product->id,
            'rating'     => 5,
            'comment'    => 'Excellent product, highly recommend!',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $review = ProductReview::first();
        $this->assertNotNull($review);
        $this->assertSame('Jane Doe', $review->name);
        $this->assertSame('jane@example.com', $review->email);
        $this->assertSame(5, $review->rating);
        // Reviews are approved by default (no moderation queue currently).
        $this->assertSame('approved', $review->status);
    }

    public function test_guest_cannot_submit_a_review(): void
    {
        $product = $this->makeProduct();

        $response = $this->postJson('/product-reviews', [
            'product_id' => $product->id,
            'rating'     => 5,
            'comment'    => 'Nice!',
        ]);

        $response->assertStatus(401);
        $this->assertSame(0, ProductReview::count());
    }

    public function test_review_requires_a_valid_rating_and_comment(): void
    {
        $product = $this->makeProduct();
        $user = User::create(['name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'secret123']);

        $response = $this->actingAs($user, 'web')->postJson('/product-reviews', [
            'product_id' => $product->id,
            'rating'     => 6,
            'comment'    => '',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['rating', 'comment']);
    }
}
