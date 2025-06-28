<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $sesi_absensi_id
 * @property int $anggota_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Anggota $anggota
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereAnggotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereSesiAbsensiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordAbsensi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RecordAbsensi extends Model
{
    use HasFactory;
    protected $fillable = ['sesi_absensi_id', 'anggota_id', 'status'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}