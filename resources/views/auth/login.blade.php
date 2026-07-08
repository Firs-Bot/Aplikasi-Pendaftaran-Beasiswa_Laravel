<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Mahasiswa Login</h2>
        <p class="text-sm text-gray-600">Masuk untuk mendaftar beasiswa</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIM / Username -->
        <div>
            <x-input-label for="nim_username" :value="__('NIM')" />
            <x-text-input id="nim_username" class="block mt-1 w-full" type="text" name="nim_username" :value="old('nim_username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nim_username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            

        </div>

        <div class="flex flex-col items-center justify-center mt-6 gap-4">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Log in') }}
            </x-primary-button>
            
            <a class="underline text-sm text-gray-600 hover:text-yellow-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" href="{{ route('admin.login') }}">
                Administrator? Login di sini
            </a>
        </div>
    </form>
</x-guest-layout>
