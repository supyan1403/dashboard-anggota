<x-guest-layout>
    <div class="min-h-screen flex bg-gray-100">
        
        <div class="hidden lg:flex w-1/3 bg-red-900 justify-center items-center p-12">
            <div class="text-center text-white">
                <img class="h-40 w-auto mx-auto mb-6" src="{{ asset('images/logo-aplikasi.png') }}" alt="Logo Aplikasi">
                <h1 class="text-3xl font-bold mb-4">Selamat Datang Kembali</h1>
                <p class="text-lg opacity-80">
                    Silakan masuk untuk melanjutkan ke dashboard admin Anda.
                </p>
            </div>
        </div>

        <div class="flex flex-1 justify-center items-center p-6 sm:p-12">
            <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
                
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-semibold text-gray-900">Login Akun</h2>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-900 shadow-sm focus:ring-red-900" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>