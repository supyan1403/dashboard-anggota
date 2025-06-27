<x-app-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Tambah Anggota Baru</h1>
        <form action="{{ route('anggota.store') }}" method="POST">
            @include('anggota._form')
        </form>
    </div>
</x-app-layout>