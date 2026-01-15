<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'nama_pemboking',
        'dokter_id',
        'jadwal_dokter_id',
        'tanggal_booking',
        'kode_booking',
        'status',
        'keluhan',
    ];

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->kode_booking)) {
                $booking->kode_booking = self::generateKodeBooking();
            }
        });
    }

    public static function generateKodeBooking()
    {
        $tanggal = now()->format('Ymd');
        $random  = strtoupper(Str::random(4));

        return "BK-{$tanggal}-{$random}";
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jadwalDokter()
    {
        return $this->belongsTo(JadwalDokter::class);
    }
}
