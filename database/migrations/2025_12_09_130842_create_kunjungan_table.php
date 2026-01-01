<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();

            $table->string('poli')->nullable();
            $table->string('keluhan')->nullable();
            $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
            $table->string('tensi')->nullable();
            $table->string('suhu')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamp('tanggal_kunjungan')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
