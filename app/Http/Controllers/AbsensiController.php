<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\SesiAbsensi;
use App\Models\RecordAbsensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        // Ambil semua sesi, urutkan dari yang terbaru
        // Gunakan withCount untuk menghitung relasi secara efisien
        $sesiAbsensi = SesiAbsensi::withCount([
            'records', // Menghasilkan kolom 'records_count' (total peserta di sesi itu)
            'records as hadir_count' => function ($query) {
                $query->where('status', 'Hadir'); // Menghasilkan 'hadir_count' (total yang hadir)
            }
        ])
            ->latest('tanggal') // Urutkan berdasarkan tanggal sesi
            ->get();

        return view('absensi.index', compact('sesiAbsensi'));
    }

    public function create()
    {
        // Mengirim tanggal hari ini sebagai nilai default ke view
        $tanggal_hari_ini = now()->format('Y-m-d');
        return view('absensi.create', compact('tanggal_hari_ini'));
    }

    // =========================================================
    // ===== METHOD BARU UNTUK MENYIMPAN SESI & RECORD AWAL =====
    // =========================================================
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        // 2. Buat Sesi Absensi baru
        $sesi = SesiAbsensi::create($validated);

        // 3. Ambil semua anggota yang statusnya aktif
        $anggotaAktif = Anggota::where('status', true)->get();

        // 4. Buat record absensi awal untuk setiap anggota aktif
        //    dengan status default 'Hadir'
        foreach ($anggotaAktif as $anggota) {
            $sesi->records()->create([
                'anggota_id' => $anggota->id,
                'status' => 'Hadir', // Status default
            ]);
        }

        // 5. Redirect ke halaman pengisian absensi (yang akan kita buat)
        //    dengan mengirimkan ID sesi yang baru dibuat.
        return redirect()->route('absensi.edit', $sesi->id)
            ->with('success', 'Sesi absensi berhasil dibuat. Silakan isi kehadiran.');
    }

    public function show(SesiAbsensi $sesi)
    {
        // Menghitung ringkasan status kehadiran untuk sesi ini
        $sesi->loadCount([
            'records as hadir_count' => fn($q) => $q->where('status', 'Hadir'),
            'records as izin_count' => fn($q) => $q->where('status', 'Izin'),
            'records as sakit_count' => fn($q) => $q->where('status', 'Sakit'),
            'records as alpa_count' => fn($q) => $q->where('status', 'Alpa'),
        ]);

        // Mengambil daftar anggota yang hadir per kelas untuk sesi ini
        $getHadirByKelas = function ($tingkat) use ($sesi) {
            return $sesi->records()
                ->where('status', 'Hadir')
                ->whereHas('anggota', fn($q) => $q->where('tingkat_kelas', $tingkat))
                ->with('anggota')
                ->get();
        };

        $hadirKelasX = $getHadirByKelas('X');
        $hadirKelasXI = $getHadirByKelas('XI');
        $hadirKelasXII = $getHadirByKelas('XII');

        // ==========================================================
        // ===== BAGIAN BARU: Menghitung Statistik Anggota Aktif ====
        // ==========================================================
        $statistikAnggota = [
            'totalAktif' => Anggota::where('status', true)->count(),
            'aktifKelasX' => Anggota::where('tingkat_kelas', 'X')->where('status', true)->count(),
            'aktifKelasXI' => Anggota::where('tingkat_kelas', 'XI')->where('status', true)->count(),
            'aktifKelasXII' => Anggota::where('tingkat_kelas', 'XII')->where('status', true)->count(),
        ];

        // Kirim semua data ke view
        return view('absensi.show', compact(
            'sesi',
            'hadirKelasX',
            'hadirKelasXI',
            'hadirKelasXII',
            'statistikAnggota' // <-- Data baru dikirim ke view
        ));
    }

    public function edit(Request $request, SesiAbsensi $sesi)
    {
        // 1. Tentukan tab tingkatan kelas yang aktif. Default-nya 'X'.
        $tingkatAktif = $request->query('tingkat', 'X');

        // 2. Ambil record absensi untuk sesi ini,
        //    DAN filter berdasarkan tingkatan kelas anggota terkait.
        $records = $sesi->records()
            ->with('anggota') // Eager load data anggota
            ->whereHas('anggota', function ($query) use ($tingkatAktif) {
                $query->where('tingkat_kelas', $tingkatAktif);
            })
            ->paginate(15) // Tampilkan 15 anggota per halaman
            ->withQueryString(); // Agar pagination mengingat tab aktif

        return view('absensi.edit', [
            'sesi' => $sesi,
            'records' => $records,
            'tingkatAktif' => $tingkatAktif // Kirim info tab aktif ke view
        ]);
    }


    /**
     * Menyimpan perubahan data absensi.
     */
    public function update(Request $request, SesiAbsensi $sesi)
    {
        // Validasi bahwa input 'status' adalah sebuah array
        $request->validate(['status' => 'required|array']);

        // Loop melalui setiap status yang dikirim dari form
        foreach ($request->status as $recordId => $newStatus) {
            // Cari record absensi berdasarkan ID dan update statusnya
            RecordAbsensi::find($recordId)->update(['status' => $newStatus]);
        }

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil disimpan!');
    }

    public function destroy(SesiAbsensi $sesi)
    {
        // Hapus data sesi dari database
        $sesi->delete();

        // Karena kita sudah mengatur 'onDelete('cascade')' di migrasi,
        // semua record absensi yang terkait dengan sesi ini akan otomatis terhapus.

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('absensi.index')->with('success', 'Sesi absensi berhasil dihapus.');
    }
}
