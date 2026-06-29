<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nim');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('jurusan');
            $table->decimal('ipk', 3, 2);
            $table->string('email');
            $table->string('no_hp');
            $table->string('file_sktm');
            $table->string('file_rekomendasi');
            $table->string('file_transkrip');
            $table->enum('status_verifikasi', ['MENUNGGU', 'SEDANG DITINJAU', 'LOLOS', 'DITOLAK'])->default('MENUNGGU');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
