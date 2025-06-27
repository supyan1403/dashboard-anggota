<x-guest-layout>
    <div class="min-h-screen flex bg-gray-100">
        
        <div class="hidden lg:flex w-1/3 bg-red-900 justify-center items-center p-12">
            <div class="text-center text-white">
                <img class="h-16 w-auto mx-auto mb-6" src="https://tailwindui.com/img/logos/mark.svg?color=white" alt="Logo Aplikasi">
                <h1 class="text-3xl font-bold mb-4">Lupa Password Anda?</h1>
                <p class="text-lg opacity-80">
                    Tidak masalah. Cukup masukkan email Anda dan kami akan membantu Anda.
                </p>
            </div>
        </div>

        <div class="flex flex-1 justify-center items-center p-6 sm:p-12">
            <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
                
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.') }}
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900">
                            {{ __('Kirim Tautan Reset Password') }}
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-red-800 hover:text-red-700">
                            &larr; Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>