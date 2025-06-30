<x-app-layout>
    {{-- Form untuk Peserta --}}
    <form action="{{ route('kegiatan.peserta.sync', $kegiatan->id) }}" method="POST">
        @csrf
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Kelola Kegiatan</h1>
                <p class="text-gray-600">
                    Kegiatan: <span class="font-semibold">{{ $kegiatan->nama_kegiatan }}</span> | Tanggal: <span class="font-semibold">{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }}</span>
                </p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('kegiatan.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">Kembali</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-500 disabled:opacity-25 transition ease-in-out duration-150">Simpan Perubahan Peserta</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <p class="text-sm text-gray-600 mb-6">Centang nama-nama anggota yang ikut berpartisipasi dalam kegiatan ini, lalu klik "Simpan Perubahan" di atas.</p>
            @php
                $tingkatan = ['X', 'XI', 'XII'];
            @endphp
            @foreach ($tingkatan as $tingkat)
                @if(isset($anggotaByTingkat[$tingkat]) && $anggotaByTingkat[$tingkat]->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Daftar Anggota Kelas {{ $tingkat }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($anggotaByTingkat[$tingkat] as $anggota)
                                <label class="flex items-start p-3 border rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                                    <input type="checkbox" name="peserta_ids[]" value="{{ $anggota->id }}" class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mt-1"
                                           @if(in_array($anggota->id, $pesertaIds)) checked @endif>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-800">{{ $anggota->nama }}</span>
                                        <span class="block text-gray-500">{{ $anggota->kelas }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </form>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Dokumentasi Foto</h2>

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Upload Foto Baru (Autosave)</h3>

        <input type="file" id="foto-input-autosave" name="fotos[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">

        <div id="upload-status-container" class="mt-2 text-sm text-gray-500"></div>
    </div>

    <div>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Galeri Dokumentasi</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($kegiatan->fotos as $foto)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $foto->path) }}" class="w-full h-40 object-cover rounded-lg">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <form action="{{ route('fotos.destroy', $foto->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white text-2xl font-bold">&times;</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">Belum ada foto dokumentasi.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    {{-- Script untuk Checkbox Peserta (tidak berubah) --}}
    <script>
        // ... script untuk checkbox peserta Anda di sini ...
    </script>

    {{-- SCRIPT BARU UNTUK AUTOSAVE UPLOAD FOTO --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('foto-input-autosave');
            const statusContainer = document.getElementById('upload-status-container');
            const kegiatanId = {{ $kegiatan->id }};
            const uploadUrl = "{{ route('kegiatan.fotos.store', $kegiatan->id) }}";
            const csrfToken = '{{ csrf_token() }}';

            if (fileInput && statusContainer) {
                fileInput.addEventListener('change', function (event) {
                    const files = event.target.files;
                    if (files.length === 0) {
                        return;
                    }

                    statusContainer.innerHTML = `<span class="text-blue-600">Mengupload ${files.length} file...</span>`;

                    const formData = new FormData();
                    for (const file of files) {
                        formData.append('fotos[]', file);
                    }

                    fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            // Jika sukses, muat ulang halaman untuk melihat galeri baru
                            window.location.reload();
                        } else {
                            // Jika gagal, tampilkan pesan error
                            return response.json().then(data => {
                                let errorMessages = data.message || 'Gagal upload file.';
                                if (data.errors) {
                                    for (const key in data.errors) {
                                        errorMessages += `\n- ${data.errors[key].join('\n- ')}`;
                                    }
                                }
                                statusContainer.innerHTML = `<span class="text-red-600">Error: ${errorMessages}</span>`;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusContainer.innerHTML = '<span class="text-red-600">Terjadi kesalahan jaringan.</span>';
                    });
                });
            }
        });
    </script>
@endpush
</x-app-layout>

