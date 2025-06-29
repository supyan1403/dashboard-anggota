<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Manajemen Kegiatan</h1>
        <a href="{{ route('kegiatan.create') }}"
            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">+ Tambah Kegiatan</a>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-500 uppercase text-sm">
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($kegiatans as $kegiatan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-semibold">{{ $kegiatan->nama_kegiatan }}</td>
                            <td class="py-3 px-4">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }}</td>
                            <td class="py-3 px-4 truncate max-w-xs">{{ $kegiatan->deskripsi ?? '-' }}</td>
  <td class="py-3 px-4 text-center">
    <div class="flex items-center justify-center gap-4">
        <a href="{{ route('kegiatan.show', $kegiatan->id) }}" class="text-blue-500 font-medium hover:text-blue-700">Detail</a>
        <a href="{{ route('kegiatan.manage', $kegiatan->id) }}" class="text-green-500 font-medium hover:text-green-700">Peserta & Foto</a>
        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="text-yellow-500 font-medium hover:text-yellow-700">Edit</a>
        <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 font-medium hover:text-red-700">Delete</button>
        </form>
    </div>
</td>                  </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">Belum ada data kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $kegiatans->links() }}</div>
    </div>
</x-app-layout>
