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
    Schema::create('record_absensis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sesi_absensi_id')->constrained()->onDelete('cascade');
        $table->foreignId('anggota_id')->constrained()->onDelete('cascade');
        $table->string('status'); // Hadir, Izin, Sakit, Alpa
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_absensis');
    }
};
