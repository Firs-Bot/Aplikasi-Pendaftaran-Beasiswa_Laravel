<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin-login');

        $response->assertStatus(200);
    }

    public function test_mahasiswa_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'nim_username' => $user->nim_username,
            'password' => 'Password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('mhs.dashboard', absolute: false));
    }

    public function test_baak_and_admin_can_authenticate_using_admin_login_screen(): void
    {
        $baak = User::factory()->baak()->create(['nim_username' => 'baak_test']);
        $admin = User::factory()->admin()->create(['nim_username' => 'admin_test']);

        $responseBaak = $this->post('/admin-login', [
            'nim_username' => $baak->nim_username,
            'password' => 'Password123',
        ]);
        $this->assertAuthenticatedAs($baak);
        $responseBaak->assertRedirect(route('baak.dashboard', absolute: false));

        $this->post('/logout');

        $responseAdmin = $this->post('/admin-login', [
            'nim_username' => $admin->nim_username,
            'password' => 'Password123',
        ]);
        $this->assertAuthenticatedAs($admin);
        $responseAdmin->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_admin_cannot_login_on_mahasiswa_portal(): void
    {
        $admin = User::factory()->admin()->create(['nim_username' => 'admin_portal']);

        $response = $this->post('/login', [
            'nim_username' => $admin->nim_username,
            'password' => 'Password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('nim_username');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'nim_username' => $user->nim_username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_login_rate_limiting_blocks_after_five_failed_attempts(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'nim_username' => $user->nim_username,
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post('/login', [
            'nim_username' => $user->nim_username,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('nim_username');
        $this->assertStringContainsString(
            'Too many',
            implode(' ', session('errors')->get('nim_username'))
        );
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
