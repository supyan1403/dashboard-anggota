<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembina extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika nama model tidak jamak
    protected $table = 'pembina';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'periode',
    ];
}