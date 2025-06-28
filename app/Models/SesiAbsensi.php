<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $tanggal
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecordAbsensi> $records
 * @property-read int|null $records_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesiAbsensi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SesiAbsensi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal', 'keterangan'];

    public function records()
    {
        return $this->hasMany(RecordAbsensi::class);
    }
}