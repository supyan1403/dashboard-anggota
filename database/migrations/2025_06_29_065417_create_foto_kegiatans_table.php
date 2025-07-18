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
    Schema::create('foto_kegiatans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kegiatan_id')->constrained()->onDelete('cascade');
        $table->string('path'); // Menyimpan path/lokasi file gambar
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_kegiatans');
    }
};
