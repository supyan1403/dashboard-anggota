<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $tingkat_kelas
 * @property string $pengelompokan_kelas
 * @property string $kelas
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AnggotaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota wherePengelompokanKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereTingkatKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anggota whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tingkat_kelas',
        'pengelompokan_kelas',
        'kelas',
        'status',
    ];

    // app/Models/Anggota.php
   public function kegiatanYangDiikuti()
{
    return $this->belongsToMany(Kegiatan::class, 'anggota_kegiatan');
}
}
