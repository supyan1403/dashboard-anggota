<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\KegiatanController;
use App\Models\Anggota; // Import model Anggota
use App\Models\Pembina; // Asumsi ada model Pembina
use App\Models\SesiAbsensi;
use App\Models\Kegiatan;

// Halaman landing default, bisa dihapus jika tidak perlu
Route::redirect('/', '/login');

// Dashboard utama setelah login
// routes/web.php

Route::get('/dashboard', function () {
    // Data untuk kartu statistik
    $totalAnggota = Anggota::count();
    $anggotaAktif = Anggota::where('status', true)->count(); // <-- TAMBAHKAN BARIS INI
    $pembinaTerbaru = Pembina::latest()->first();

    // Data untuk grafik distribusi anggota
    $anggotaPerKelas = [
        'X' => Anggota::where('tingkat_kelas', 'X')->count(),
        'XI' => Anggota::where('tingkat_kelas', 'XI')->count(),
        'XII' => Anggota::where('tingkat_kelas', 'XII')->count(),
    ];
    $chartData = [
        'labels' => array_keys($anggotaPerKelas),
        'data' => array_values($anggotaPerKelas),
    ];

    // Data untuk widget absensi terakhir
    $sesiTerbaru = \App\Models\SesiAbsensi::withCount([
        'records as hadir_count' => fn($q) => $q->where('status', 'Hadir'),
        'records as izin_count' => fn($q) => $q->where('status', 'Izin'),
        'records as sakit_count' => fn($q) => $q->where('status', 'Sakit'),
        'records as alpa_count' => fn($q) => $q->where('status', 'Alpa'),
    ])->latest('tanggal')->first();

     $kegiatanTerbaru = Kegiatan::with('pesertas')->latest('tanggal_kegiatan')->first();

     $chartPesertaData = null; // Default null jika tidak ada kegiatan
    if ($kegiatanTerbaru) {
        $pesertasByTingkat = $kegiatanTerbaru->pesertas->groupBy('tingkat_kelas');
        $chartPesertaData = [
            'labels' => ['Peserta Kelas X', 'Peserta Kelas XI', 'Peserta Kelas XII'],
            'data' => [
                $pesertasByTingkat->get('X', collect())->count(),
                $pesertasByTingkat->get('XI', collect())->count(),
                $pesertasByTingkat->get('XII', collect())->count(),
            ]
        ];
    }

    // Kirim semua data ke view
    return view('dashboard', [
        'totalAnggota' => $totalAnggota,
        'anggotaAktif' => $anggotaAktif, // <-- PASTIKAN DIKIRIM DI SINI
        'pembina' => $pembinaTerbaru,
        'chartData' => $chartData,
        'sesiTerbaru' => $sesiTerbaru,
        'kegiatanTerbaru' => $kegiatanTerbaru,
         'chartPesertaData' => $chartPesertaData, 
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

Route::post('/kegiatan/{kegiatan}/peserta', [KegiatanController::class, 'syncPeserta'])->name('kegiatan.peserta.sync');
Route::get('/kegiatan/{kegiatan}/manage', [KegiatanController::class, 'manage'])->name('kegiatan.manage');
Route::post('/kegiatan/{kegiatan}/fotos', [KegiatanController::class, 'uploadFoto'])->name('kegiatan.fotos.store');
Route::delete('/kegiatan/fotos/{foto}', [KegiatanController::class, 'destroyFoto'])->name('fotos.destroy');
Route::resource('kegiatan', KegiatanController::class);

    // Untuk Absensi
    Route::resource('absensi', AbsensiController::class)->parameters([
        'absensi' => 'sesi'
    ]);
});


require __DIR__ . '/auth.php';
