<?php

namespace App\Models;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama_dokter',
        'no_hp',
        'image',
        'poli_id',
    ];

    // Relasi ke Poli
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalDokter::class);
    }
}
