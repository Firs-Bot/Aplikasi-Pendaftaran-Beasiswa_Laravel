<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter table to add 'baak' to enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'baak', 'mahasiswa') DEFAULT 'mahasiswa'");
        
        // Update existing admin to baak
        DB::table('users')->where('role', 'admin')->update(['role' => 'baak']);
        
        // Create new admin_super user
        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator Sistem',
            'nim_username' => 'admin_super',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete the super admin
        DB::table('users')->where('nim_username', 'admin_super')->delete();
        
        // Revert baak to admin
        DB::table('users')->where('role', 'baak')->update(['role' => 'admin']);
        
        // Revert enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mahasiswa') DEFAULT 'mahasiswa'");
    }
};
