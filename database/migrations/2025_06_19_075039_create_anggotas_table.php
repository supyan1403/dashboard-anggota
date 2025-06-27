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
    Schema::create('anggotas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('tingkat_kelas'); // Contoh: 'X', 'XI', 'XII'
        $table->string('pengelompokan_kelas'); // Contoh: '1', '2', '3', '4'
        $table->string('kelas'); // Contoh: 'XI - 4'. Ini bisa digenerate otomatis.
        $table->boolean('status')->default(true); // true = Aktif, false = Tidak Aktif
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
