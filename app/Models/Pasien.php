<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'status_bpjs',
        'alergi',
        'catatan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pasien) {
            $latest = self::orderBy('id', 'desc')->first();
            $nextNumber = $latest ? $latest->id + 1 : 1;

        $pasien->no_rm = 'RM-' . date('Y') . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }
}
