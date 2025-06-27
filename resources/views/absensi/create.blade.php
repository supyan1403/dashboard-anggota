<x-app-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Buat Sesi Absensi Baru</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Absensi</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $tanggal_hari_ini) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan/Kegiatan</label>
                <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Latihan Rutin Mingguan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('absensi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Simpan & Lanjutkan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>