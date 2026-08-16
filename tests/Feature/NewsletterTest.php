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

    /**
     * The homepage newsletter form's anti-spam honeypot label ("Leave this
     * field empty if you're human:") must stay visually hidden from real
     * visitors — it's only there for bots that blindly fill every field.
     * Locks down the visually-hidden CSS technique so it can't regress back
     * to plain, visible text above the subscribe form.
     */
    public function test_newsletter_honeypot_label_is_visually_hidden(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString("Leave this field empty if you're human:", $html);

        preg_match('/<label style="([^"]*)"\s+aria-hidden="true">\s*Leave this field empty/', $html, $m);
        $this->assertNotEmpty($m, 'Could not find the honeypot label markup');

        $style = $m[1];
        foreach (['clip:rect(0,0,0,0)', 'clip-path:inset(50%)', 'width:1px', 'height:1px', 'overflow:hidden'] as $rule) {
            $this->assertStringContainsString($rule, $style, "Honeypot label is missing '{$rule}' — it may render as visible text");
        }
    }
}
