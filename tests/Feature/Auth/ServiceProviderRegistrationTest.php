<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceProviderRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_as_normal_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            // is_service_provider is not sent, simulating unchecked box
        ]);

        $this->assertAuthenticated();
        
        // Assert user has correct role
        $this->assertEquals('user', User::first()->role);

        // Assert redirection to user dashboard
        $response->assertRedirect(route('user.dashboard', absolute: false));
    }

    public function test_new_users_can_register_as_service_provider(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Provider',
            'email' => 'provider@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_service_provider' => '1', // Simulating checked box
        ]);

        $this->assertAuthenticated();

        // Assert user has correct role
        $this->assertEquals('service_provider', User::first()->role);

        // Assert redirection to service provider dashboard
        $response->assertRedirect(route('service-provider.dashboard', absolute: false));
    }

    public function test_service_provider_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'service_provider',
        ]);

        $response = $this->actingAs($user)->get(route('service-provider.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('service_provider.dashboard');
    }

    public function test_normal_user_cannot_access_service_provider_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(route('service-provider.dashboard'));

        $response->assertStatus(403);
    }
}
