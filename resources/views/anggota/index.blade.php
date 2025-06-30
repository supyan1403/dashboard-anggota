<x-app-layout>
    <h1 class="text-3xl font-semibold text-gray-800">Manajemen Anggota</h1>

    <div class="mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600 font-medium">Total Anggota</h3>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('anggota.migrate.form') }}"
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Naik Kelas
                    </a>
                    <a href="{{ route('anggota.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Tambah Anggota
                    </a>
                </div>
            </div>
            <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md flex flex-col">
                <div>
                    <h3 class="text-gray-600 font-medium">Status Keanggotaan</h3>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['aktif'] }} <span
                            class="text-2xl font-medium text-gray-500">/ {{ $stats['total'] }} Anggota Aktif</span></p>
                </div>

                <div class="flex-grow"></div>

                <div>
                    @php
                        $total = $stats['total'];
                        $aktif = $stats['aktif'];
                        $tidak_aktif = $total - $aktif;

                        // Hitung persentase dengan aman untuk menghindari pembagian dengan nol
                        if ($total > 0) {
                            $persentase_aktif = ($aktif / $total) * 100;
                            $persentase_tidak_aktif = ($tidak_aktif / $total) * 100;
                        } else {
                            $persentase_aktif = 0;
                            $persentase_tidak_aktif = 0;
                        }
                    @endphp

                    <div class="flex w-full h-3 rounded-full overflow-hidden bg-gray-200 mt-4">
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
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
                <div>
                    <h3 class="text-gray-600 font-medium">Anggota Kelas X</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['kelas_x'] }}</p>
                </div>
                <div class="flex-grow"></div>
                <div>
                    @php
                        $total = $stats['kelas_x'];
                        $aktif = $stats['aktif_kelas_x'];
                        $persentase_aktif = $total > 0 ? ($aktif / $total) * 100 : 0;
                        $persentase_tidak_aktif = 100 - $persentase_aktif;
                    @endphp
                    <div class="flex w-full h-2 rounded-full overflow-hidden bg-gray-200 mt-4">
                        <div class="bg-green-500" style="width: {{ $persentase_aktif }}%"></div>
                        <div class="bg-red-500" style="width: {{ $persentase_tidak_aktif }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 flex justify-between">
                        <span>Aktif: <strong>{{ $aktif }}</strong></span>
                        <span>Tidak Aktif: <strong>{{ $total - $aktif }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
                <div>
                    <h3 class="text-gray-600 font-medium">Anggota XI</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['kelas_xi'] }}</p>
                </div>
                <div class="flex-grow"></div>
                <div>
                    @php
                        $total = $stats['kelas_xi'];
                        $aktif = $stats['aktif_kelas_xi'];
                        $persentase_aktif = $total > 0 ? ($aktif / $total) * 100 : 0;
                        $persentase_tidak_aktif = 100 - $persentase_aktif;
                    @endphp
                    <div class="flex w-full h-2 rounded-full overflow-hidden bg-gray-200 mt-4">
                        <div class="bg-green-500" style="width: {{ $persentase_aktif }}%"></div>
                        <div class="bg-red-500" style="width: {{ $persentase_tidak_aktif }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 flex justify-between">
                        <span>Aktif: <strong>{{ $aktif }}</strong></span>
                        <span>Tidak Aktif: <strong>{{ $total - $aktif }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
                <div>
                    <h3 class="text-gray-600 font-medium">Anggota XII</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['kelas_xii'] }}</p>
                </div>
                <div class="flex-grow"></div>
                <div>
                    @php
                        $total = $stats['kelas_xii'];
                        $aktif = $stats['aktif_kelas_xii'];
                        $persentase_aktif = $total > 0 ? ($aktif / $total) * 100 : 0;
                        $persentase_tidak_aktif = 100 - $persentase_aktif;
                    @endphp
                    <div class="flex w-full h-2 rounded-full overflow-hidden bg-gray-200 mt-4">
                        <div class="bg-green-500" style="width: {{ $persentase_aktif }}%"></div>
                        <div class="bg-red-500" style="width: {{ $persentase_tidak_aktif }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 flex justify-between">
                        <span>Aktif: <strong>{{ $aktif }}</strong></span>
                        <span>Tidak Aktif: <strong>{{ $total - $aktif }}</strong></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">

            <form action="{{ route('anggota.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div>
                    <select name="filter_tingkat" class="border-gray-300 rounded-lg shadow-sm text-sm">
                        <option value="">Semua Tingkat</option>
                        <option value="X" @selected(request('filter_tingkat') == 'X')>X</option>
                        <option value="XI" @selected(request('filter_tingkat') == 'XI')>XI</option>
                        <option value="XII" @selected(request('filter_tingkat') == 'XII')>XII</option>
                    </select>
                </div>

                <div>
                    <select name="filter_kelompok" class="border-gray-300 rounded-lg shadow-sm text-sm">
                        <option value="">Semua Kelompok</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @selected(request('filter_kelompok') == $i)>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Filter</button>
                    <a href="{{ route('anggota.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-100 disabled:opacity-25 transition ease-in-out duration-150">Reset</a>
                </div>
            </form>

            <form action="{{ route('anggota.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari Nama atau Kelas..."
                        class="border rounded-lg px-4 py-2 w-full text-sm" value="{{ request('search') }}">
                    <button type="submit" class="absolute top-0 right-0 h-full px-4 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-500 uppercase text-sm">

                        <th class="py-3 px-4">
                            @php
                                // Logika untuk membalik arah sorting
                                $idDirection =
                                    request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc';
                            @endphp
                            <a href="{{ route('anggota.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => $idDirection])) }}"
                                class="flex items-center gap-2">
                                <span>ID</span>
                                @if (request('sort') == 'id')
                                    <i
                                        class="fa-solid {{ $idDirection == 'asc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort text-gray-300"></i>
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-4">
                            @php
                                $namaDirection =
                                    request('sort') == 'nama' && request('direction') == 'asc' ? 'desc' : 'asc';
                            @endphp
                            <a href="{{ route('anggota.index', array_merge(request()->query(), ['sort' => 'nama', 'direction' => $namaDirection])) }}"
                                class="flex items-center gap-2">
                                <span>Nama</span>
                                @if (request('sort') == 'nama')
                                    <i
                                        class="fa-solid {{ $namaDirection == 'asc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort text-gray-300"></i>
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-4">
                            @php
                                $kelasDirection =
                                    request('sort') == 'kelas' && request('direction') == 'asc' ? 'desc' : 'asc';
                            @endphp
                            <a href="{{ route('anggota.index', array_merge(request()->query(), ['sort' => 'kelas', 'direction' => $kelasDirection])) }}"
                                class="flex items-center gap-2">
                                <span>Kelas</span>
                                @if (request('sort') == 'kelas')
                                    <i
                                        class="fa-solid {{ $kelasDirection == 'asc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort text-gray-300"></i>
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-4">
                            @php
                                $statusDirection =
                                    request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc';
                            @endphp
                            <a href="{{ route('anggota.index', array_merge(request()->query(), ['sort' => 'status', 'direction' => $statusDirection])) }}"
                                class="flex items-center gap-2">
                                <span>Status</span>
                                @if (request('sort') == 'status')
                                    <i
                                        class="fa-solid {{ $statusDirection == 'asc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort text-gray-300"></i>
                                @endif
                            </a>
                        </th>

                        <th class="py-3 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($anggotas as $anggota)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-semibold">{{ $anggota->id }}</td>
                            <td class="py-3 px-4">{{ $anggota->nama }}</td>
                            <td class="py-3 px-4">{{ $anggota->kelas }}</td>
                            <td class="py-3 px-4">
                                <span
                                    class="{{ $anggota->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} py-1 px-3 rounded-full text-xs font-medium">
                                    {{ $anggota->status ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 flex justify-center items-center gap-3">
                                <a href="{{ route('anggota.edit', $anggota->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 font-medium">Edit</a>

                                <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $anggotas->links() }}
        </div>
    </div>
</x-app-layout>
