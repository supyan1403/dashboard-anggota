<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <aside
            class="w-64 text-white flex-shrink-0 flex flex-col fixed h-screen bg-gradient-to-b from-gray-800 to-gray-900">
            <div class="h-16 flex items-center justify-center flex-shrink-0 border-b border-gray-700/50">
                <h2 class="text-xl font-semibold tracking-wider text-white">Admin Panel</h2>
            </div>

            <div class="flex flex-col justify-between flex-grow">

                <nav class="mt-4">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 py-3 px-6 transition-colors duration-200 
                      {{ request()->routeIs('dashboard')
                          ? 'bg-gray-700/50 text-white border-l-4 border-red-500'
                          : 'text-gray-400 hover:bg-gray-700/50 hover:text-white' }}">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span>Home</span>
                    </a>

                    <a href="{{ route('anggota.index') }}"
                        class="flex items-center gap-3 py-3 px-6 transition-colors duration-200
                      {{ request()->routeIs('anggota.*')
                          ? 'bg-gray-700/50 text-white border-l-4 border-red-500'
                          : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fa-solid fa-users fa-fw"></i>
                        <span>Anggota</span>
                    </a>

                    <a href="{{ route('pembina.index') }}"
                        class="flex items-center gap-3 py-3 px-6 transition-colors duration-200
                      {{ request()->routeIs('pembina.*')
                          ? 'bg-gray-700/50 text-white border-l-4 border-red-500'
                          : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fa-solid fa-user-tie fa-fw"></i>
                        <span>Pembina</span>
                    </a>

                    <a
                        href="{{ route('absensi.index') }}"class="flex items-center gap-3 py-3 px-6 transition-colors duration-200 {{ request()->routeIs('absensi.*')
                            ? 'bg-gray-700/50 text-white border-l-4 border-red-500'
                            : 'text-gray-400 hover:bg-gray-700/50 hover:text-white' }}">
                        <i class="fa-solid fa-clipboard-user fa-fw"></i>
                        <span>Absensi</span>
                    </a>
                </nav>

                <div class="px-4 py-4 mt-4">
                    <hr class="border-t border-gray-700 mb-4">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center justify-center gap-3 w-full py-2 px-4 rounded-lg text-red-400 hover:bg-red-500 hover:text-white transition-colors duration-200">
                            <i class="fa-solid fa-right-from-bracket fa-fw"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden ml-64">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
                @if (session('success'))
                    <div id="alert-session"
                        class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 transition-all duration-500 ease-in-out"
                        role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                        <button type="button"
                            onclick="document.getElementById('alert-session').style.display = 'none';"
                            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                            aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
        // Script untuk delete confirmation (SweetAlert2)
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('delete-form')) {
                e.preventDefault();
                const form = e.target;
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: "Anda akan menghapus data ini secara permanen.",
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan Hapus',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 mr-2',
                        cancelButton: 'px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });

        // Script untuk notifikasi hilang otomatis
        document.addEventListener('DOMContentLoaded', function() {
            const alertElement = document.getElementById('alert-session');
            if (alertElement) {
                setTimeout(() => {
                    alertElement.classList.add('opacity-0', '-translate-y-4');
                    setTimeout(() => {
                        alertElement.style.display = 'none';
                    }, 500);
                }, 2000);
            }
        });
    </script>
</body>

</html>
