<x-guest-layout>
    <div class="min-h-screen flex bg-white">

        <div class="hidden lg:flex w-3/5 relative">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/login-background.jpg') }}" alt="Background Login">
            <div class="absolute inset-0 bg-gradient-to-t from-red-900 via-red-800/80 to-red-600/30"></div>
            <div class="relative z-10 flex flex-col justify-center items-center w-full text-white p-12">
                <div class="mb-8">
                    <img class="h-40 w-auto" src="{{ asset('images/logo-aplikasi.png') }}" alt="Logo Aplikasi">
                </div>
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight">Lupa Password Anda?</h1>
                    <p class="mt-4 text-lg max-w-lg opacity-80">
                        Tidak masalah. Cukup masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-gray-50">
            <div class="mx-auto w-full max-w-sm">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Reset Password</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Masukkan email terdaftar Anda di bawah ini.
                    </p>
                </div>

                <div class="mt-8">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                       class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                    class="flex w-full justify-center rounded-md border border-transparent bg-red-800 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Kirim Tautan Reset Password
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            &larr; Kembali ke halaman Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>