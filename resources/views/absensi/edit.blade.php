<x-app-layout>
    <form action="{{ route('absensi.update', $sesi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Isi Kehadiran</h1>
                <p class="text-gray-600">
                    Kegiatan: <span class="font-semibold">{{ $sesi->keterangan }}</span> | Tanggal: <span
                        class="font-semibold">{{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }}</span>
                </p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('absensi.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Simpan
                    Absensi</button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex gap-x-6 px-6" aria-label="Tabs">
                    @php $tabs = ['X', 'XI', 'XII']; @endphp
                    @foreach ($tabs as $tab)
                        <a href="{{ route('absensi.edit', ['sesi' => $sesi->id, 'tingkat' => $tab]) }}"
                            class="{{ $tingkatAktif == $tab
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                   whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Kelas {{ $tab }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-500 uppercase text-sm">
                            <th class="py-3 px-6">Nama Anggota</th>
                            <th class="py-3 px-4">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($records as $record)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-6">
                                    <div class="font-semibold">{{ $record->anggota->nama ?? 'Anggota Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->anggota->kelas ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap gap-x-6 gap-y-2">
                                        @php $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa']; @endphp
                                        @foreach ($statuses as $status)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="status[{{ $record->id }}]"
                                                    value="{{ $status }}"
                                                    class="form-radio h-5 w-5 text-indigo-600 focus:ring-indigo-500"
                                                    @checked($record->status == $status)>
                                                <span class="ml-2">{{ $status }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-10 text-gray-500">
                                    Tidak ada anggota di tingkat kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-200">
                {{ $records->links() }}
            </div>
        </div>
    </form>
</x-app-layout>
