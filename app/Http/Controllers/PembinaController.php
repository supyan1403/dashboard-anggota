<?php

namespace App\Http\Controllers;

use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib ada untuk mengelola file

class PembinaController extends Controller
{
    /**
     * Menampilkan daftar semua pembina.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua periode unik dari database untuk pilihan filter
        // diurutkan dari yang terbaru, dan hanya yang tidak kosong.
        $periods = Pembina::query()
            ->select('periode')
            ->whereNotNull('periode')
            ->distinct()
            ->orderBy('periode', 'desc')
            ->pluck('periode');

        // 2. Buat query dasar
        $query = Pembina::query();

        // 3. Terapkan logika pencarian jika ada input search
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('jabatan', 'like', '%' . $searchTerm . '%');
            });
        }

        // 4. TERAPKAN LOGIKA FILTER PERIODE (BAGIAN BARU)
        if ($request->filled('filter_periode')) {
            $query->where('periode', $request->input('filter_periode'));
        }

        // 5. Ambil data dengan paginasi dan sorting, lalu tambahkan withQueryString()
        $pembina = $query->latest()->paginate(5)->withQueryString();

        // 6. Kirim data ke view, termasuk variabel $periods
        return view('pembina.index', compact('pembina', 'periods'));
    }

    /**
     * Menampilkan form untuk membuat pembina baru.
     */
    public function create()
    {
        return view('pembina.create');
    }

    /**
     * Menyimpan pembina baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // foto boleh kosong, harus gambar, max 2MB
            'periode' => 'nullable|string|max:9',
        ]);

        // 2. Cek jika ada file foto yang di-upload
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder public/pembina_fotos dan ambil path-nya
            $path = $request->file('foto')->store('pembina_fotos', 'public');
            $validatedData['foto'] = $path;
        }

        // 3. Buat data pembina baru
        Pembina::create($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data pembina.
     */
    public function edit(Pembina $pembina)
    {
        return view('pembina.edit', compact('pembina'));
    }

    /**
     * Mengupdate data pembina di database.
     */
    public function update(Request $request, Pembina $pembina)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'periode' => 'nullable|string|max:9',
        ]);

        // 2. Cek jika ada file foto baru yang di-upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pembina->foto) {
                Storage::disk('public')->delete($pembina->foto);
            }

            // Simpan foto baru dan update path-nya
            $path = $request->file('foto')->store('pembina_fotos', 'public');
            $validatedData['foto'] = $path;
        }

        // 3. Update data pembina
        $pembina->update($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil diperbarui!');
    }

    /**
     * Menghapus data pembina dari database.
     */
    public function destroy(Pembina $pembina)
    {
        // Hapus foto dari storage jika ada
        if ($pembina->foto) {
            Storage::disk('public')->delete($pembina->foto);
        }

        // Hapus data dari database
        $pembina->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil dihapus.');
    }
}
