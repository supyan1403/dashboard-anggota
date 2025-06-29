<x-app-layout>
    <h1 class="text-3xl font-semibold text-gray-800">Selamat Datang di Dashboard Admin</h1>
    <p class="mt-2 text-gray-600">Di dalam halaman dashboard admin, anda bisa mengelola dan mengakses seluruh fitur.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
            <div>
                <h3 class="text-lg font-medium text-gray-700">Total Anggota</h3>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalAnggota }}</p>
            </div>

            <div class="flex-grow"></div>

            <div>
                @php
                    // Hitung data untuk progress bar
                    $total = $totalAnggota;
                    $aktif = $anggotaAktif;
                    $tidak_aktif = $total - $aktif;

                    if ($total > 0) {
                        $persentase_aktif = ($aktif / $total) * 100;
                        $persentase_tidak_aktif = ($tidak_aktif / $total) * 100;
                    } else {
                        $persentase_aktif = 0;
                        $persentase_tidak_aktif = 0;
                    }
                @endphp

                <div class="flex w-full h-2 rounded-full overflow-hidden bg-gray-200 mt-4">
                    <div class="bg-green-500" style="width: {{ $persentase_aktif }}%"></div>
                    <div class="bg-red-500" style="width: {{ $persentase_tidak_aktif }}%"></div>
                </div>

                <div class="mt-2 flex justify-between text-sm text-gray-600">
                    <div>
                        <span class="inline-block h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                        Aktif: <strong>{{ $aktif }}</strong>
                    </div>
                    <div>
                        <span class="inline-block h-2 w-2 rounded-full bg-red-500 mr-1"></span>
                        Tidak Aktif: <strong>{{ $tidak_aktif }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Pembina Terbaru</h3>
            @if ($pembina)
                <div class="flex items-center gap-4">
                    <img src="{{ $pembina->foto ? asset('storage/' . $pembina->foto) : asset('images/default-profile.png') }}"
                        alt="{{ $pembina->nama }}" class="h-16 w-16 object-cover rounded-full flex-shrink-0">
                    <div>
                        <p class="text-xl font-bold text-gray-900 truncate">{{ $pembina->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $pembina->periode ?? 'Periode belum diatur' }}</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 mt-2">Belum ada data pembina.</p>
            @endif
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Anggota per Kelas</h3>
        <div style="height: 300px;">
            <canvas id="distribusiAnggotaChart"></canvas>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Kehadiran Terakhir</h3>
            @if ($sesiTerbaru)
                <div style="height: 250px;" class="flex justify-center items-center">
                    <canvas id="absensiPieChart"></canvas>
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-16">Belum ada data absensi.</p>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Absensi Terakhir</h3>
            @if ($sesiTerbaru)
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Kegiatan</p>
                        <p class="font-semibold text-gray-800">{{ $sesiTerbaru->keterangan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($sesiTerbaru->tanggal)->format('d F Y') }}</p>
                    </div>
                    <div class="border-t pt-4">
                        <a href="{{ route('absensi.show', $sesiTerbaru->id) }}"
                            class="font-medium text-indigo-600 hover:text-indigo-800">
                            Lihat Laporan Detail &rarr;
                        </a>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-16">Belum ada data absensi.</p>
            @endif
        </div>

        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Kegiatan Terakhir Dilaksanakan</h3>
                <a href="{{ route('kegiatan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lihat
                    Semua &rarr;</a>
            </div>

            @if ($kegiatanTerbaru)
                <div>
                    <h4 class="text-xl font-bold text-gray-900">{{ $kegiatanTerbaru->nama_kegiatan }}</h4>
                    <p class="text-sm text-gray-500 mb-4">
                        {{ \Carbon\Carbon::parse($kegiatanTerbaru->tanggal_kegiatan)->format('d F Y') }}
                    </p>

                    <h5 class="font-semibold text-gray-800 mt-4 mb-2">Daftar Peserta
                        ({{ $kegiatanTerbaru->pesertas->count() }} orang):</h5>

                    @if ($kegiatanTerbaru->pesertas->isNotEmpty())
                        <ul
                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-1 text-sm text-gray-600">
                            @foreach ($kegiatanTerbaru->pesertas as $peserta)
                                <li class="truncate" title="{{ $peserta->nama }}">{{ $peserta->nama }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 italic">Belum ada peserta yang ditambahkan untuk kegiatan ini.
                        </p>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500">Belum ada data kegiatan yang dilaksanakan.</p>
            @endif
        </div>

         <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Komposisi Peserta</h3>
        @if($kegiatanTerbaru && $kegiatanTerbaru->pesertas->count() > 0)
            <div style="height: 250px; position: relative;">
                <canvas id="kegiatanPesertaChart"></canvas>
            </div>
        @else
            <div class="text-center text-gray-400 flex items-center justify-center h-full">
                <p>Tidak ada data peserta untuk ditampilkan di grafik.</p>
            </div>
        @endif
    </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (isset($chartData))
                    const chartData = @json($chartData);
                    const ctx = document.getElementById('distribusiAnggotaChart');

                    if (ctx) {
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: chartData.labels,
                                datasets: [{
                                    label: 'Jumlah Anggota',
                                    data: chartData.data,
                                    backgroundColor: [
                                        'rgba(239, 68, 68, 0.5)',
                                        'rgba(59, 130, 246, 0.5)',
                                        'rgba(22, 163, 74, 0.5)'
                                    ],
                                    borderColor: [
                                        'rgba(239, 68, 68, 1)',
                                        'rgba(59, 130, 246, 1)',
                                        'rgba(22, 163, 74, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                @endif
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Cek jika data sesi terbaru ada
                @if (isset($sesiTerbaru))
                    const pieCtx = document.getElementById('absensiPieChart');

                    if (pieCtx) {
                        new Chart(pieCtx, {
                            type: 'doughnut', // Tipe grafik: doughnut (seperti donat)
                            data: {
                                labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                                datasets: [{
                                    label: 'Status Kehadiran',
                                    data: [
                                        {{ $sesiTerbaru->hadir_count }},
                                        {{ $sesiTerbaru->izin_count }},
                                        {{ $sesiTerbaru->sakit_count }},
                                        {{ $sesiTerbaru->alpa_count }}
                                    ],
                                    backgroundColor: [
                                        'rgba(22, 163, 74, 0.8)', // Hijau
                                        'rgba(59, 130, 246, 0.8)', // Biru
                                        'rgba(234, 179, 8, 0.8)', // Kuning
                                        'rgba(239, 68, 68, 0.8)' // Merah
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom', // Pindahkan legenda ke bawah
                                    }
                                }
                            }
                        });
                    }
                @endif
            });
        </script>

          <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($chartPesertaData))
                const ctx = document.getElementById('kegiatanPesertaChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: @json($chartPesertaData['labels']),
                            datasets: [{
                                label: 'Jumlah Peserta',
                                data: @json($chartPesertaData['data']),
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.7)',  // Biru
                                    'rgba(22, 163, 74, 0.7)',   // Hijau
                                    'rgba(239, 68, 68, 0.7)'   // Merah
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>

        
    @endpush

</x-app-layout>
