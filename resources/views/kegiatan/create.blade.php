<x-app-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Tambah Kegiatan Baru</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('kegiatan.store') }}" method="POST">
            @include('kegiatan._form')
        </form>
    </div>
</x-app-layout>