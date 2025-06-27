<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Anda bisa membuat 1 user default untuk login jika mau
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'paskibrasmanespa@gmail.com',
        ]);

        // Panggil AnggotaSeeder yang sudah kita buat
        $this->call([
            AnggotaSeeder::class,
        ]);
    }
}