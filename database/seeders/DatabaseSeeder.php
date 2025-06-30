<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menghapus atau memberi komentar pada User::factory(10) jika ada
        // User::factory(10)->create();

        // Membuat satu user admin secara spesifik
        User::create([
            'name' => 'Admin',
            'username' => 'admin', // <-- Ini username untuk login
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // <-- Passwordnya adalah 'password'
        ]);

        // Anda juga bisa memanggil seeder lain di sini jika perlu
        $this->call([
            AnggotaSeeder::class,
        ]);
    }
}