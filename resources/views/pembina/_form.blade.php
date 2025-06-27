@csrf
<div class="mb-4">
    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama', $pembina->nama ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
    @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pembina->jabatan ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
    @error('jabatan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label for="periode" class="block text-sm font-medium text-gray-700">Periode Tahun Ajaran</label>
    <select name="periode" id="periode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- Pilih Periode --</option>
        
        @php
            $currentYear = date('Y');
            $currentMonth = date('n');
            $academicYearStart = ($currentMonth >= 7) ? $currentYear : $currentYear - 1;
        @endphp

        @for ($year = 2024; $year <= $academicYearStart + 5; $year++)
            @php
                $periodeOption = $year . '/' . ($year + 1);
            @endphp
            <option value="{{ $periodeOption }}" @selected(old('periode', $pembina->periode ?? '') == $periodeOption)>
                {{ $periodeOption }}
            </option>
        @endfor

    </select>
    @error('periode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Foto</label>
    <div class="mt-2 flex items-center gap-x-4">
        @php
            // Tentukan path gambar yang akan ditampilkan
            $foto_url = (isset($pembina) && $pembina->foto) 
                        ? asset('storage/' . $pembina->foto) 
                        : asset('images/default-profile.png');
        @endphp
        <img id="foto-preview" src="{{ $foto_url }}" alt="Preview" class="h-24 w-24 object-cover rounded-full bg-gray-100">

        <div>
            <label for="foto" class="cursor-pointer rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <span>{{ (isset($pembina) && $pembina->foto) ? 'Ganti Foto' : 'Pilih Foto' }}</span>
            </label>
            <input type="file" name="foto" id="foto" class="hidden">
            <p class="mt-3 text-xs text-gray-500">PNG, JPG, GIF up to 2MB.</p>
        </div>
    </div>
    @error('foto') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
</div>


<div class="flex items-center justify-end gap-4 mt-8">
    <a href="{{ route('pembina.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
        Batal
    </a>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-500 disabled:opacity-25 transition ease-in-out duration-150">
        {{ isset($pembina) ? 'Simpan Perubahan' : 'Tambah Pembina' }}
    </button>
</div>

@push('scripts')
<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('foto-preview');
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush