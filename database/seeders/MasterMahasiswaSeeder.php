<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterMahasiswa;

class MasterMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nim' => '20230001', 'nama_lengkap' => 'Budi Santoso', 'jurusan' => 'Teknik Informatika'],
            ['nim' => '20230002', 'nama_lengkap' => 'Siti Aminah', 'jurusan' => 'Sistem Informasi'],
            ['nim' => '20230003', 'nama_lengkap' => 'Andi Wijaya', 'jurusan' => 'Desain Komunikasi Visual'],
            ['nim' => '20230004', 'nama_lengkap' => 'Rina Melati', 'jurusan' => 'Manajemen Informatika'],
            ['nim' => '20230005', 'nama_lengkap' => 'Ahmad Fauzi', 'jurusan' => 'Teknik Komputer'],
            ['nim' => '20240810034', 'nama_lengkap' => 'Muhammad Fahmi Firmansyah', 'jurusan' => 'Teknik Informatika'],
            ['nim' => '20240810091', 'nama_lengkap' => 'Arie Muhamad Syahrial', 'jurusan' => 'Teknik Informatika'],
            ['nim' => '20240810129', 'nama_lengkap' => 'Salwa Hamdunah', 'jurusan' => 'Teknik Informatika'],
        ];

        foreach ($data as $item) {
            MasterMahasiswa::firstOrCreate(['nim' => $item['nim']], $item);
        }
    }
}
