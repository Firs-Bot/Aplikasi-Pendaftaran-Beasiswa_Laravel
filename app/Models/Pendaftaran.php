<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = ['user_id', 'beasiswa_id', 'nama_lengkap', 'nim', 'jenis_kelamin', 'jurusan', 'ipk', 'email', 'no_hp', 'file_sktm', 'file_rekomendasi', 'file_transkrip', 'status_verifikasi'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function beasiswa() {
        return $this->belongsTo(Beasiswa::class);
    }
}
