@csrf
<div class="mb-4">
    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
</div>
<div class="mb-4">
    <label for="tanggal_kegiatan" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
    <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $kegiatan->tanggal_kegiatan ?? now()->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
</div>
<div class="mb-4">
    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
    <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('deskripsi', $kegiatan->deskripsi ?? '') }}</textarea>
</div>
<div class="flex items-center justify-end gap-4 mt-6">
    <a href="{{ route('kegiatan.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">Batal</a>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-500 disabled:opacity-25 transition ease-in-out duration-150">{{ isset($kegiatan) ? 'Simpan Perubahan' : 'Simpan Kegiatan' }}</button>
</div>