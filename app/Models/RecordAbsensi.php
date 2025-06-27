<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordAbsensi extends Model
{
    use HasFactory;
    protected $fillable = ['sesi_absensi_id', 'anggota_id', 'status'];
}