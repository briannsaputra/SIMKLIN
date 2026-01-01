<?php

namespace App\Models;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama_dokter',
        'spesialis',
        'no_hp',
        'image',
        'poli_id',
    ];

    // Relasi ke Poli
    public function dokter()
    {
        return $this->belongsTo(Poli::class);
    }
}
