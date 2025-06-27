<x-app-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Data Pembina</h1>
        <form action="{{ route('pembina.update', $pembina->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('pembina._form', ['pembina' => $pembina])
        </form>
    </div>
</x-app-layout>
