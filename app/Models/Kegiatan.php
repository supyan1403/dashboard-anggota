<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_kegiatan',
    ];

    public function pesertas()
{
    return $this->belongsToMany(Anggota::class, 'anggota_kegiatan');
}

public function fotos()
{
    return $this->hasMany(FotoKegiatan::class);
}


}
