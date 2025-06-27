<x-app-layout>
    <form action="{{ route('anggota.migrate.action') }}" method="POST">
        @csrf
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Migrasi & Pengelompokan Kelas</h1>
            <div class="flex gap-4">
                <a href="{{ route('anggota.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900">Simpan
                    Perubahan & Lanjutkan</button>
            </div>
        </div>

        <div class="p-4 mb-6 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
            <span class="font-bold">Peringatan!</span> Saat Anda menyimpan, semua anggota Kelas XII akan dihapus
            (lulus). Pastikan semua data sudah benar.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Calon Anggota Kelas XII</h2>
                <div class="space-y-4">
                    @forelse($calon_kelas_xii as $anggota)
                        <div class="grid grid-cols-3 items-center gap-4">
                            <span class="col-span-2 truncate" title="{{ $anggota->nama }}">{{ $anggota->nama }} <span
                                    class="text-xs text-gray-500">({{ $anggota->kelas }})</span></span>
                            <div class="flex items-center">
                                <span class="font-semibold mr-2">XII - </span>
                                <input type="number" name="updates[{{ $anggota->id }}]"
                                    value="{{ $anggota->pengelompokan_kelas }}"
                                    class="w-20 border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada anggota di Kelas XI.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Calon Anggota Kelas XI</h2>
                <div class="space-y-4">
                    @forelse($calon_kelas_xi as $anggota)
                        <div class="grid grid-cols-3 items-center gap-4">
                            <span class="col-span-2 truncate" title="{{ $anggota->nama }}">{{ $anggota->nama }} <span
                                    class="text-xs text-gray-500">({{ $anggota->kelas }})</span></span>
                            <div class="flex items-center">
                                <span class="font-semibold mr-2">XI - </span>
                                <input type="number" name="updates[{{ $anggota->id }}]"
                                    value="{{ $anggota->pengelompokan_kelas }}"
                                    class="w-20 border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada anggota di Kelas X.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
