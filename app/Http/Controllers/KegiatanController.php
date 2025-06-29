<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kegiatan;
use App\Models\FotoKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    // Method CRUD dasar untuk Kegiatan
    public function index() { $kegiatans = Kegiatan::latest('tanggal_kegiatan')->paginate(10); return view('kegiatan.index', compact('kegiatans')); }
    public function create() { return view('kegiatan.create'); }
    public function store(Request $request) {
        $validatedData = $request->validate(['nama_kegiatan' => 'required|string|max:255', 'deskripsi' => 'nullable|string', 'tanggal_kegiatan' => 'required|date']);
        Kegiatan::create($validatedData);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan baru berhasil ditambahkan.');
    }
    public function show(Kegiatan $kegiatan) {
        $kegiatan->load(['pesertas' => fn($q) => $q->orderBy('nama'), 'fotos']);
        $pesertasByTingkat = $kegiatan->pesertas->groupBy('tingkat_kelas');
        $chartPesertaData = [
        'labels' => ['Kelas X', 'Kelas XI', 'Kelas XII'],
        'data' => [
            $pesertasByTingkat->get('X', collect())->count(),
            $pesertasByTingkat->get('XI', collect())->count(),
            $pesertasByTingkat->get('XII', collect())->count(),
        ]
    ];
        return view('kegiatan.show', [ 'kegiatan' => $kegiatan, 'pesertasX' => $pesertasByTingkat->get('X', collect()), 'pesertasXI' => $pesertasByTingkat->get('XI', collect()), 'pesertasXII' => $pesertasByTingkat->get('XII', collect()),  'chartPesertaData' => $chartPesertaData, ]);
    }
    public function edit(Kegiatan $kegiatan) { $kegiatan->tanggal_kegiatan = \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('Y-m-d'); return view('kegiatan.edit', compact('kegiatan')); }
    public function update(Request $request, Kegiatan $kegiatan) {
        $validatedData = $request->validate(['nama_kegiatan' => 'required|string|max:255', 'deskripsi' => 'nullable|string', 'tanggal_kegiatan' => 'required|date']);
        $kegiatan->update($validatedData);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }
    public function destroy(Kegiatan $kegiatan) {
        foreach ($kegiatan->fotos as $foto) { Storage::disk('public')->delete($foto->path); }
        $kegiatan->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Method untuk halaman Kelola Peserta & Foto
 public function manage(Kegiatan $kegiatan)
{
    // 1. Ambil SEMUA anggota yang statusnya aktif, urutkan
    $semuaAnggota = \App\Models\Anggota::where('status', true)
                            ->orderBy('tingkat_kelas', 'asc')
                            ->orderBy('pengelompokan_kelas', 'asc')
                            ->orderBy('nama', 'asc')
                            ->get();

    // 2. Kelompokkan mereka berdasarkan tingkat kelasnya
    $anggotaByTingkat = $semuaAnggota->groupBy('tingkat_kelas');

    // 3. Ambil ID dari anggota yang sudah terdaftar sebagai peserta
    $pesertaIds = $kegiatan->pesertas->pluck('id')->toArray();

    $anggotaCounts = Anggota::where('status', true)
        ->select('tingkat_kelas', DB::raw('count(*) as total'))
        ->groupBy('tingkat_kelas')
        ->pluck('total', 'tingkat_kelas');

    // 4. Kirim data yang sudah dikelompokkan ke view (TANPA $tingkatAktif)
    return view('kegiatan.manage', compact(
        'kegiatan', 
        'anggotaByTingkat',
        'pesertaIds',
        'anggotaCounts'
    ));
}

    // Method untuk menyimpan data Peserta
    public function syncPeserta(Request $request, Kegiatan $kegiatan)
    {
        $request->validate(['peserta_ids' => 'nullable|array']);
        $kegiatan->pesertas()->sync($request->input('peserta_ids', []));
        return redirect()->route('kegiatan.manage', ['kegiatan' => $kegiatan->id, 'tingkat' => $request->input('tingkat_sekarang', 'X')])->with('success', 'Data peserta berhasil diperbarui.');
    }

    // Method untuk mengelola foto
    public function uploadFoto(Request $request, Kegiatan $kegiatan)
{
    // Validasi, pastikan ada file dan formatnya benar
    $request->validate([
        'fotos' => 'required|array',
        'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
    ], [
        'fotos.*.image' => 'File yang diupload harus berupa gambar.',
        'fotos.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
        'fotos.*.max' => 'Ukuran gambar maksimal 2MB.',
    ]);

    // Loop dan simpan setiap file
    foreach ($request->file('fotos') as $file) {
        $path = $file->store('kegiatan_dokumentasi', 'public');
        $kegiatan->fotos()->create(['path' => $path]);
    }

    // Kembalikan respons JSON yang menandakan sukses
    return response()->json(['success' => true, 'message' => 'Foto berhasil di-upload.']);
}


    public function destroyFoto(FotoKegiatan $foto)
    {
        Storage::disk('public')->delete($foto->path);
        $foto->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}