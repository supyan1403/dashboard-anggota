<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PembinaController;
use App\Models\Anggota; // Import model Anggota
use App\Models\Pembina; // Asumsi ada model Pembina
use App\Http\Controllers\AbsensiController;

// Halaman landing default, bisa dihapus jika tidak perlu
Route::redirect('/', '/login');

// Dashboard utama setelah login
// routes/web.php

Route::get('/dashboard', function () {
    // Data untuk kartu statistik
    $totalAnggota = Anggota::count();
    $anggotaAktif = Anggota::where('status', true)->count(); // <-- TAMBAHKAN INI
    $pembinaTerbaru = Pembina::latest()->first();

    // Data untuk grafik
    $anggotaPerKelas = [
        'X' => Anggota::where('tingkat_kelas', 'X')->count(),
        'XI' => Anggota::where('tingkat_kelas', 'XI')->count(),
        'XII' => Anggota::where('tingkat_kelas', 'XII')->count(),
    ];
    $chartData = [
        'labels' => array_keys($anggotaPerKelas),
        'data' => array_values($anggotaPerKelas),
    ];

    // Kirim semua data ke view
    return view('dashboard', [
        'totalAnggota' => $totalAnggota,
        'anggotaAktif' => $anggotaAktif, // <-- Kirim data baru
        'pembina' => $pembinaTerbaru,
        'chartData' => $chartData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    // ===============================================
    // ===== RUTE BARU UNTUK KENAIKAN KELAS (TAMBAHKAN DI SINI) =====
    // ===============================================
    Route::get('/anggota/migrate', [AnggotaController::class, 'showMigrationForm'])->name('anggota.migrate.form');
    Route::post('/anggota/migrate', [AnggotaController::class, 'processMigration'])->name('anggota.migrate.action');

    // Resource route untuk Anggota
    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota'
    ]);

    // Resource route untuk Pembina
    Route::resource('pembina', PembinaController::class);

    // Untuk Absensi
    Route::resource('absensi', AbsensiController::class)->parameters([
        'absensi' => 'sesi'
    ]);
});


require __DIR__ . '/auth.php';
