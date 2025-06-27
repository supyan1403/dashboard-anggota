<x-app-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Data Anggota</h1>
        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
            @method('PUT')
            @include('anggota._form', ['anggota' => $anggota])
        </form>
    </div>
</x-app-layout>