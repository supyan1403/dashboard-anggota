<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal', 'keterangan'];

    public function records()
    {
        return $this->hasMany(RecordAbsensi::class);
    }
}