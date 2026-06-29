<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $fillable = ['nama_beasiswa', 'penyedia', 'deskripsi', 'foto'];
}
