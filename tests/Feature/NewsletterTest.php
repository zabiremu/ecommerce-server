<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_email_is_subscribed(): void
    {
        $response = $this->postJson('/newsletter/subscribe', ['email' => 'jane@example.com']);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertSame(1, Subscriber::where('email', 'jane@example.com')->count());
    }

    public function test_already_subscribed_email_does_not_create_a_duplicate(): void
    {
        Subscriber::create(['email' => 'jane@example.com', 'source' => 'homepage']);

        $response = $this->postJson('/newsletter/subscribe', ['email' => 'jane@example.com']);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertSame(1, Subscriber::where('email', 'jane@example.com')->count());
    }

    public function test_invalid_email_is_rejected(): void
    {
        $response = $this->postJson('/newsletter/subscribe', ['email' => 'not-an-email']);

        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }
}
