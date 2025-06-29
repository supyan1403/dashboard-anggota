<x-app-layout>
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Kegiatan</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
            @method('PUT')
            @include('kegiatan._form', ['kegiatan' => $kegiatan])
        </form>
    </div>
</x-app-layout>