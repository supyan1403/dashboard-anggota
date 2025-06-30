<x-guest-layout>
    <div class="min-h-screen bg-white flex">

        <div class="hidden lg:block relative w-0 flex-1">
            {{-- Pastikan nama gambar sesuai dengan yang Anda simpan --}}
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/login-background.jpg') }}" alt="Background">
            
            {{-- Overlay Gradasi --}}
            <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 to-transparent"></div>
            
            {{-- Konten Branding di Atas Overlay --}}
            <div class="absolute inset-0 flex flex-col justify-end text-white p-12">
                <h1 class="text-4xl font-bold tracking-tight">Manajemen Terpadu</h1>
                <p class="mt-3 text-lg max-w-sm opacity-80">
                    Satu platform untuk mengelola anggota, kegiatan, dan absensi dengan efisien.
                </p>
            </div>
        </div>
        

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    {{-- Logo di atas form --}}
                    <img class="h-20 w-auto" src="{{ asset('images/logo-aplikasi.png') }}" alt="Logo Aplikasi">
                    <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Selamat Datang, Admin</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Silakan masuk untuk melanjutkan.
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required
                                           class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                                </div>

                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <button type="submit"
                                        class="flex w-full justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>