<x-app-layout>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Tambah Pembina Baru</h1>
        <form action="{{ route('pembina.store') }}" method="POST" enctype="multipart/form-data">
            @include('pembina._form')
        </form>
    </div>
</x-app-layout>