<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Manajemen Pembina</h1>
        <a href="{{ route('pembina.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            + Tambah Pembina
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">

            <form action="{{ route('pembina.index') }}" method="GET" class="w-full md:w-auto">
                <select name="filter_periode" onchange="this.form.submit()"
                    class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" disabled @if (!request()->has('filter_periode')) selected @endif>Pilih Periode
                    </option>

                    <option value="" @selected(request()->input('filter_periode') === '')>Semua Periode</option>

                    @foreach ($periods as $period)
                        <option value="{{ $period }}" @selected(request('filter_periode') == $period)>
                            {{ $period }}
                        </option>
                    @endforeach
                </select>
            </form>

            <form action="{{ route('pembina.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari Nama atau Jabatan..."
                        class="border rounded-lg px-4 py-2 w-full" value="{{ request('search') }}">
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
                        <th class="py-3 px-4">Foto</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Jabatan</th>
                        <th class="py-3 px-4">Periode</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($pembina as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                        class="h-16 w-16 object-cover rounded-full">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile"
                                        class="h-16 w-16 object-cover rounded-full">
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold">{{ $item->nama }}</td>
                            <td class="py-3 px-4">{{ $item->jabatan }}</td>
                            <td class="py-3 px-4">{{ $item->periode ?? '-' }}</td>
                            <td class="py-3 px-4 flex justify-center items-center gap-3 h-24">
                                <a href="{{ route('pembina.edit', $item->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 font-medium">Edit</a>
                                <form action="{{ route('pembina.destroy', $item->id) }}" method="POST"
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
                            <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada data pembina yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pembina->links() }}
        </div>
    </div>
</x-app-layout>
