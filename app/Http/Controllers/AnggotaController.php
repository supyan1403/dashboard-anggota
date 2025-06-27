<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Penting untuk transaksi database

class AnggotaController extends Controller
{
    /**
     * Menampilkan halaman utama Anggota dengan semua data.
     */
    public function index(Request $request)
    {
        // 1. Hitung statistik
        $stats = [
            'total' => Anggota::count(),
            'aktif' => Anggota::where('status', true)->count(),
            'kelas_x' => Anggota::where('tingkat_kelas', 'X')->count(),
            'kelas_xi' => Anggota::where('tingkat_kelas', 'XI')->count(),
            'kelas_xii' => Anggota::where('tingkat_kelas', 'XII')->count(),
            'aktif_kelas_x' => Anggota::where('tingkat_kelas', 'X')->where('status', true)->count(),
            'aktif_kelas_xi' => Anggota::where('tingkat_kelas', 'XI')->where('status', true)->count(),
            'aktif_kelas_xii' => Anggota::where('tingkat_kelas', 'XII')->where('status', true)->count(),
        ];

        // 2. Buat query dasar
        $query = Anggota::query();
        
        // 3. Logika Filter, Search, dan Sort (sekarang langsung di sini)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kelas', 'like', '%' . $searchTerm . '%');
            });
        }

       // Filter berdasarkan Tingkat Kelas (X, XI, XII)
if ($request->filled('filter_tingkat')) {
    $query->where('tingkat_kelas', $request->input('filter_tingkat'));
}

// Filter berdasarkan Pengelompokan Kelas (1, 2, 3, ...)
if ($request->filled('filter_kelompok')) {
    $query->where('pengelompokan_kelas', $request->input('filter_kelompok'));
}

        $sortColumn = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'desc');
        $allowedSortColumns = ['id', 'nama', 'kelas', 'status'];
        if (!in_array($sortColumn, $allowedSortColumns)) $sortColumn = 'id';

        if ($sortColumn == 'kelas') {
            $query->orderBy('tingkat_kelas', $sortDirection)
                  ->orderByRaw('CAST(pengelompokan_kelas AS UNSIGNED) ' . $sortDirection);
        } else {
            $query->orderBy($sortColumn, $sortDirection);
        }

        // 4. Lakukan paginasi untuk tampilan awal
        $anggotas = $query->paginate(10)->withQueryString();

        // 5. Kirim data ke view
        return view('anggota.index', [
            'anggotas' => $anggotas,
            'stats' => $stats
        ]);
    }
    
    // ===============================================
    // ===== METHOD BARU UNTUK KENAIKAN KELAS ======
    // ===============================================

    /**
     * Menampilkan form migrasi untuk kenaikan kelas.
     */
    public function showMigrationForm()
    {
        // Ambil semua anggota yang akan naik kelas, urutkan berdasarkan nama
        $calon_kelas_xi = Anggota::where('tingkat_kelas', 'X')->orderBy('nama', 'asc')->get();
        $calon_kelas_xii = Anggota::where('tingkat_kelas', 'XI')->orderBy('nama', 'asc')->get();

        // Kirim data ke view 'anggota.migrate'
        return view('anggota.migrate', compact('calon_kelas_xi', 'calon_kelas_xii'));
    }

    /**
     * Memproses data dari form migrasi dan menjalankan kenaikan kelas.
     */
    public function processMigration(Request $request)
    {
        // Validasi bahwa 'updates' adalah sebuah array (jika dikirim)
        $request->validate([
            'updates' => 'sometimes|array'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Luluskan/Hapus Anggota Kelas XII
                Anggota::where('tingkat_kelas', 'XII')->delete();

                // 2. Update data anggota berdasarkan input dari form
                if ($request->has('updates')) {
                    foreach ($request->updates as $id => $pengelompokan) {
                        $anggota = Anggota::find($id);
                        if ($anggota) {
                            $tingkat_lama = $anggota->tingkat_kelas;
                            $tingkat_baru = ($tingkat_lama == 'X') ? 'XI' : 'XII';

                            $anggota->update([
                                'tingkat_kelas' => $tingkat_baru,
                                'pengelompokan_kelas' => $pengelompokan,
                                'kelas' => $tingkat_baru . ' - ' . $pengelompokan
                            ]);
                        }
                    }
                }
            });

            return redirect()->route('anggota.index')->with('success', 'Migrasi kenaikan kelas berhasil diselesaikan!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat proses migrasi: ' . $e->getMessage()]);
        }
    }


    // ===============================================
    // ===== METHOD CRUD STANDAR (TETAP SAMA) ======
    // ===============================================

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat_kelas' => 'required|string',
            'pengelompokan_kelas' => 'required|string',
            'kelas' => 'required|string',
        ]);
        $validated['status'] = $request->has('status');
        Anggota::create($validated);
        return redirect()->route('anggota.index')->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat_kelas' => 'required|string',
            'pengelompokan_kelas' => 'required|string',
            'kelas' => 'required|string',
        ]);
        $validated['status'] = $request->has('status');
        $anggota->update($validated);
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}