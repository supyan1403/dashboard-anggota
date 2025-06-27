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
    @endpush

</x-app-layout>
