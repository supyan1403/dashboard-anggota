<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota; // <-- Jangan lupa import model Anggota

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Perintah ini akan membuat 50 data anggota menggunakan AnggotaFactory
        Anggota::factory()->count(50)->create();
    }
}