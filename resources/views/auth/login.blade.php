<x-guest-layout>
    <div class="min-h-screen flex bg-white">

        {{-- Lebar diubah menjadi 3/5 agar lebih dominan --}}
        <div class="hidden lg:flex w-3/5 relative">
            {{-- Gambar Latar --}}
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/login-background.jpg') }}" alt="Background Login">
            
            {{-- Overlay Gradasi --}}
            <div class="absolute inset-0 bg-gradient-to-br from-red-900/10 via-red-900/80 to-transparant
            "></div>

            {{-- Konten diletakkan di tengah dengan flexbox --}}
            <div class="relative z-10 flex flex-col justify-center items-center w-full text-white p-12">
                
                {{-- LOGO DIPERBAIKI (dibungkus div agar tidak gepeng) --}}
                <div class="mb-2 h-auto w-auto">
                    <img class="h-40 w-auto" src="{{ asset('images/logo-aplikasi.png') }}" alt="Logo Aplikasi">
                </div>

                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight">
                        Manajemen Terpadu
                    </h1>
                    <p class="mt-4 text-lg max-w-lg opacity-80">
                        Satu platform untuk mengelola semua data keanggotaan, kegiatan, dan absensi dengan efisien.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-gray-50">
            <div class="mx-auto w-full max-w-sm">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Selamat Datang, Admin</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Silakan masuk untuk melanjutkan.
                    </p>
                </div>

                <div class="mt-8">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <div class="mt-1">
            <input id="username" name="username" type="text" autocomplete="username" required value="{{ old('username') }}"
                   class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm">
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
    </div>

                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                            </div>
                             <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                            </div>
                        
                        </div>

                        <div>
                            <button type="submit"
                                    class="flex w-full justify-center rounded-md border border-transparent bg-red-800 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>