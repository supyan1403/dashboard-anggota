<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Kita buat variabel dulu untuk Tingkat dan Pengelompokan
        $tingkat = fake()->randomElement(['X', 'XI', 'XII']);
        $pengelompokan = fake()->numberBetween(1, 12); // Misal ada kelas 1 sampai 5

        return [
            'nama' => fake()->name(),
            'tingkat_kelas' => $tingkat,
            'pengelompokan_kelas' => $pengelompokan,
            'kelas' => $tingkat . ' - ' . $pengelompokan, // Gabungkan keduanya
            'status' => fake()->boolean(90), // 90% kemungkinan statusnya akan true (Aktif)
        ];
    }
}