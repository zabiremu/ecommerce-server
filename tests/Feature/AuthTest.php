<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', [
            'first_name'            => 'John',
            'last_name'             => 'Smith',
            'email'                 => 'john@example.com',
            'phone'                 => '01800000000',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'john@example.com')->first(), 'web');
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::create([
            'name' => 'Existing', 'email' => 'dup@example.com', 'password' => 'secret123',
        ]);

        $response = $this->from('/register')->post('/register', [
            'first_name'            => 'John',
            'last_name'             => 'Smith',
            'email'                 => 'dup@example.com',
            'phone'                 => '01800000000',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
    }

    public function test_customer_can_log_in_with_valid_credentials(): void
    {
        User::create([
            'name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'secret123',
        ]);

        $response = $this->post('/login', [
            'email'    => 'jane@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'jane@example.com')->first(), 'web');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::create([
            'name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'secret123',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email'    => 'jane@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('web');
    }
}
