<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Riwayat Absensi</h1>
        <a href="{{ route('absensi.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Buat Absensi Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-500 uppercase text-sm">
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Kegiatan</th>
                        <th class="py-3 px-4">Jumlah Hadir</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($sesiAbsensi as $sesi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }}</td>
                            <td class="py-3 px-4">{{ $sesi->keterangan }}</td>

                            <td class="py-3 px-4">
                                <span class="font-semibold">{{ $sesi->hadir_count }}</span>
                                <span class="text-gray-500">/ {{ $sesi->records_count }}</span>
                            </td>

                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ route('absensi.show', $sesi->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">Lihat Detail</a>

                                    <a href="{{ route('absensi.edit', $sesi->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700 font-medium">Edit</a>

                                    <form action="{{ route('absensi.destroy', $sesi->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                Belum ada sesi absensi yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
