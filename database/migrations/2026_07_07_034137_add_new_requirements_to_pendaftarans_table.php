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
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('file_aktif_kuliah')->nullable()->after('file_transkrip');
            $table->string('file_ktp')->nullable()->after('file_aktif_kuliah');
            $table->string('file_ktm')->nullable()->after('file_ktp');
            $table->string('file_krs')->nullable()->after('file_ktm');
            $table->string('file_tidak_menerima_beasiswa')->nullable()->after('file_krs');
            $table->enum('penghasilan_ortu', [
                '< 500000',
                '500000 - 1000000',
                '1000000 - 1500000',
                '1500000 - 2000000',
                '> 2000000'
            ])->nullable()->after('file_tidak_menerima_beasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'file_aktif_kuliah',
                'file_ktp',
                'file_ktm',
                'file_krs',
                'file_tidak_menerima_beasiswa',
                'penghasilan_ortu'
            ]);
        });
    }
};
