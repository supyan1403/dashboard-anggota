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
    <a href="{{ route('kegiatan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">{{ isset($kegiatan) ? 'Simpan Perubahan' : 'Simpan Kegiatan' }}</button>
</div>