<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $jabatan
 * @property string|null $periode
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina wherePeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembina whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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