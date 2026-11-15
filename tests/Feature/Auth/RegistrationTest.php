<?php

namespace Tests\Feature\Auth;

use App\Models\MasterMahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_weak_password_is_rejected_on_registration(): void
    {
        MasterMahasiswa::create([
            'nim' => '20240810099',
            'nama_lengkap' => 'Mahasiswa Uji',
            'jurusan' => 'Teknik Informatika',
        ]);

        $responseShort = $this->post('/register', [
            'nim_username' => '20240810099',
            'password' => '123',
            'password_confirmation' => '123',
        ]);
        $responseShort->assertSessionHasErrors('password');

        $responseLettersOnly = $this->post('/register', [
            'nim_username' => '20240810099',
            'password' => 'passwordonly',
            'password_confirmation' => 'passwordonly',
        ]);
        $responseLettersOnly->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['nim_username' => '20240810099']);
    }

    public function test_unregistered_nim_is_rejected(): void
    {
        $response = $this->post('/register', [
            'nim_username' => '99999999999',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);

        $response->assertSessionHasErrors('nim_username');
        $this->assertDatabaseMissing('users', ['nim_username' => '99999999999']);
    }

    public function test_new_mahasiswa_can_register_with_valid_nim_and_strong_password(): void
    {
        MasterMahasiswa::create([
            'nim' => '20240810098',
            'nama_lengkap' => 'Mahasiswa Valid',
            'jurusan' => 'Teknik Informatika',
        ]);

        $response = $this->post('/register', [
            'nim_username' => '20240810098',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
        ]);

        $this->assertDatabaseHas('users', [
            'nim_username' => '20240810098',
            'nama_lengkap' => 'Mahasiswa Valid',
            'role' => 'mahasiswa',
        ]);
        $response->assertRedirect(route('login', absolute: false));
    }
}
