@csrf <div class="mb-4">
    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama', $anggota->nama ?? '') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        required>
    @error('nama')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
    <div>
        <label for="tingkat_kelas" class="block text-sm font-medium text-gray-700">Tingkat Kelas</label>
        <select name="tingkat_kelas" id="tingkat_kelas"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            required>
            <option value="" disabled
                {{ old('tingkat_kelas', $anggota->tingkat_kelas ?? '') == '' ? 'selected' : '' }}>Please select</option>
            <option value="X" @selected(old('tingkat_kelas', $anggota->tingkat_kelas ?? '') == 'X')>X</option>
            <option value="XI" @selected(old('tingkat_kelas', $anggota->tingkat_kelas ?? '') == 'XI')>XI</option>
            <option value="XII" @selected(old('tingkat_kelas', $anggota->tingkat_kelas ?? '') == 'XII')>XII</option>
        </select>
        @error('tingkat_kelas')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="pengelompokan_kelas" class="block text-sm font-medium text-gray-700">Pengelompokan Kelas</label>
        <select name="pengelompokan_kelas" id="pengelompokan_kelas"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            required>
            <option value="" disabled
                {{ old('pengelompokan_kelas', $anggota->pengelompokan_kelas ?? '') == '' ? 'selected' : '' }}>Please
                select</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" @selected(old('pengelompokan_kelas', $anggota->pengelompokan_kelas ?? '') == $i)>{{ $i }}</option>
            @endfor
        </select>
        @error('pengelompokan_kelas')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
    <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $anggota->kelas ?? '') }}"
        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm" readonly>
    @error('kelas')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label for="status" class="flex items-center">
        <input type="checkbox" name="status" id="status" value="1"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            @checked(old('status', $anggota->status ?? true))>
        <span class="ms-2 text-sm text-gray-600">Aktif</span>
    </label>
</div>

<div class="flex items-center justify-end gap-4 mt-6">
    <a href="{{ route('anggota.index') }}"
        class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-25 transition ease-in-out duration-150">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-500 disabled:opacity-25 transition ease-in-out duration-150">
        {{ isset($anggota) ? 'Simpan Perubahan' : 'Tambah Anggota' }}
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tingkat = document.getElementById('tingkat_kelas');
            const pengelompokan = document.getElementById('pengelompokan_kelas');
            const kelasInput = document.getElementById('kelas');

            function updateKelas() {
                const tingkatValue = tingkat.value;
                const pengelompokanValue = pengelompokan.value;

                if (tingkatValue && pengelompokanValue) {
                    kelasInput.value = `${tingkatValue} - ${pengelompokanValue}`;
                } else {
                    kelasInput.value = '';
                }
            }

            tingkat.addEventListener('change', updateKelas);
            pengelompokan.addEventListener('change', updateKelas);
        });
    </script>
@endpush
