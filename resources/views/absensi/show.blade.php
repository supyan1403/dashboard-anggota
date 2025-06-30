<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Detail Laporan Absensi</h1>
            <p class="text-gray-600">
                Kegiatan: <span class="font-semibold">{{ $sesi->keterangan }}</span> | Tanggal: <span
                    class="font-semibold">{{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }}</span>
            </p>
        </div>
        <a href="{{ route('absensi.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-300 focus:outline-none focus:border-gray-200 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
            &larr; Kembali ke Riwayat
        </a>
    </div>

    <div class="mb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold text-lg text-gray-800 mb-2">Ringkasan Kehadiran Sesi Ini</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="p-2 bg-green-100 rounded">
                    <div class="text-2xl font-bold text-green-800">{{ $sesi->hadir_count }}</div>
                    <div class="text-sm text-green-700">Hadir</div>
                </div>
                <div class="p-2 bg-blue-100 rounded">
                    <div class="text-2xl font-bold text-blue-800">{{ $sesi->izin_count }}</div>
                    <div class="text-sm text-blue-700">Izin</div>
                </div>
                <div class="p-2 bg-yellow-100 rounded">
                    <div class="text-2xl font-bold text-yellow-800">{{ $sesi->sakit_count }}</div>
                    <div class="text-sm text-yellow-700">Sakit</div>
                </div>
                <div class="p-2 bg-red-100 rounded">
                    <div class="text-2xl font-bold text-red-800">{{ $sesi->alpa_count }}</div>
                    <div class="text-sm text-red-700">Alpa</div>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold text-lg text-gray-800 mb-2">Kehadiran / Total Anggota Aktif</h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex justify-between">
                    <span>Kelas X:</span>
                    <span class="font-medium"><strong>{{ count($hadirKelasX) }}</strong> /
                        {{ $statistikAnggota['aktifKelasX'] }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Kelas XI:</span>
                    <span class="font-medium"><strong>{{ count($hadirKelasXI) }}</strong> /
                        {{ $statistikAnggota['aktifKelasXI'] }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Kelas XII:</span>
                    <span class="font-medium"><strong>{{ count($hadirKelasXII) }}</strong> /
                        {{ $statistikAnggota['aktifKelasXII'] }}</span>
                </li>
                <li class="flex justify-between border-t pt-2 mt-2 font-bold">
                    <span>Total Hadir:</span>
                    <span><strong>{{ $sesi->hadir_count }}</strong> / {{ $statistikAnggota['totalAktif'] }}</span>
                </li>
            </ul>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Hadir Kelas X</h3>
            <ul class="space-y-2 text-gray-700">
                @forelse($hadirKelasX as $record)
                    <li class="flex justify-between">
                        <span>{{ $loop->iteration }}. {{ $record->anggota->nama ?? 'N/A' }}</span>
                        <span class="text-gray-500 text-sm">{{ $record->anggota->kelas ?? '' }}</span>
                    </li>
                @empty
                    <li class="text-gray-400 text-sm">Tidak ada yang hadir dari kelas ini.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Hadir Kelas XI</h3>
            <ul class="space-y-2 text-gray-700">
                @forelse($hadirKelasXI as $record)
                    <li class="flex justify-between">
                        <span>{{ $loop->iteration }}. {{ $record->anggota->nama ?? 'N/A' }}</span>
                        <span class="text-gray-500 text-sm">{{ $record->anggota->kelas ?? '' }}</span>
                    </li>
                @empty
                    <li class="text-gray-400 text-sm">Tidak ada yang hadir dari kelas ini.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Hadir Kelas XII</h3>
            <ul class="space-y-2 text-gray-700">
                @forelse($hadirKelasXII as $record)
                    <li class="flex justify-between">
                        <span>{{ $loop->iteration }}. {{ $record->anggota->nama ?? 'N/A' }}</span>
                        <span class="text-gray-500 text-sm">{{ $record->anggota->kelas ?? '' }}</span>
                    </li>
                @empty
                    <li class="text-gray-400 text-sm">Tidak ada yang hadir dari kelas ini.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
