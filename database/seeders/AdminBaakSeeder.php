<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminBaakSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds using credentials from environment variables.
     */
    public function run(): void
    {
        $this->seedStaffAccount(
            username: 'admin',
            namaLengkap: 'Administrator',
            role: 'admin',
            envKey: 'SEED_ADMIN_PASSWORD'
        );

        $this->seedStaffAccount(
            username: 'baak',
            namaLengkap: 'Staf BAAK',
            role: 'baak',
            envKey: 'SEED_BAAK_PASSWORD'
        );
    }

    private function seedStaffAccount(string $username, string $namaLengkap, string $role, string $envKey): void
    {
        $password = env($envKey);
        $generated = false;

        if (! is_string($password) || trim($password) === '') {
            if (User::where('nim_username', $username)->exists()) {
                $this->command?->info("Akun {$username} sudah ada; set {$envKey} di .env jika ingin mereset password.");
                return;
            }

            $password = Str::password(16);
            $generated = true;
        }

        User::updateOrCreate(
            ['nim_username' => $username],
            [
                'nama_lengkap' => $namaLengkap,
                'password' => Hash::make($password),
                'role' => $role,
            ]
        );

        if ($generated) {
            $this->command?->warn("{$envKey} tidak diset. Password acak sementara untuk '{$username}': {$password}");
        }
    }
}
