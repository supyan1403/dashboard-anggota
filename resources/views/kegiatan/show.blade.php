<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-gray-800">Detail Laporan Kegiatan</h1>
            <p class="text-gray-600">
                <span class="font-semibold">{{ $kegiatan->nama_kegiatan }}</span> | Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }}</span>
            </p>
        </div>
        <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-300 focus:outline-none focus:border-gray-200 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">&larr; Kembali</a>
    </div>

    <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-semibold text-xl text-gray-800 mb-2 border-b pb-2">Deskripsi Kegiatan</h3>
        <p class="text-gray-600 prose max-w-none">{{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
    </div>

    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ringkasan Peserta (Total: {{ $kegiatan->pesertas->count() }} orang)</h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4 text-center">Komposisi Peserta</h3>
                <div style="height: 250px;">
                    <canvas id="pesertaChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Daftar Nama Peserta</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 text-sm">
                    {{-- Kelas X --}}
                    <div>
                        <p class="font-bold text-gray-600 mb-2">Kelas X ({{ $pesertasX->count() }} orang)</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            @forelse($pesertasX as $peserta)
                                <li class="truncate" title="{{$peserta->nama}}">{{ $peserta->nama }}</li>
                            @empty
                                <li class="list-none italic text-gray-400">Nihil</li>
                            @endforelse
                        </ul>
                    </div>
                    {{-- Kelas XI --}}
                    <div>
                        <p class="font-bold text-gray-600 mb-2 mt-4 md:mt-0">Kelas XI ({{ $pesertasXI->count() }} orang)</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            @forelse($pesertasXI as $peserta)
                                <li class="truncate" title="{{$peserta->nama}}">{{ $peserta->nama }}</li>
                            @empty
                                <li class="list-none italic text-gray-400">Nihil</li>
                            @endforelse
                        </ul>
                    </div>
                    {{-- Kelas XII --}}
                    <div>
                        <p class="font-bold text-gray-600 mb-2 mt-4 md:mt-0">Kelas XII ({{ $pesertasXII->count() }} orang)</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            @forelse($pesertasXII as $peserta)
                                <li class="truncate" title="{{$peserta->nama}}">{{ $peserta->nama }}</li>
                            @empty
                                <li class="list-none italic text-gray-400">Nihil</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Galeri Dokumentasi</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($kegiatan->fotos as $foto)
                <div>
                    <a href="{{ asset('storage/' . $foto->path) }}" target="_blank" title="Lihat ukuran penuh">
                        <img src="{{ asset('storage/' . $foto->path) }}" alt="Dokumentasi Kegiatan" class="w-full h-40 object-cover rounded-lg shadow-md hover:scale-105 transition-transform duration-200">
                    </a>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">Belum ada foto dokumentasi untuk kegiatan ini.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Pastikan script Chart.js sudah dimuat di app.blade.php
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($chartPesertaData))
            const ctx = document.getElementById('pesertaChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut', // Tipe grafik diubah menjadi doughnut
                    data: {
                        labels: @json($chartPesertaData['labels']),
                        datasets: [{
                            label: 'Jumlah Peserta',
                            data: @json($chartPesertaData['data']),
                            backgroundColor: [
                                'rgba(239, 68, 68, 0.7)',   // Merah untuk Kelas X
                                'rgba(59, 130, 246, 0.7)',  // Biru untuk Kelas XI
                                'rgba(22, 163, 74, 0.7)'   // Hijau untuk Kelas XII
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            }
        @endif
    });
</script>
@endpush
</x-app-layout>
