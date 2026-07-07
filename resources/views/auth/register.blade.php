<x-guest-layout>
    <div x-data="nimValidator()" x-init="init()">
        <form method="POST" action="{{ route('register') }}"
            @submit="if(!isValidNIM) { $event.preventDefault(); alert('Harap validasi NIM Anda terlebih dahulu.'); }">
            @csrf

            <!-- Notifikasi Error NIM -->
            <div x-show="errorMessage" x-transition
                class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative"
                style="display: none;">
                <span class="block sm:inline" x-text="errorMessage"></span>
            </div>

            <!-- Notifikasi Sukses NIM -->
            <div x-show="successMessage" x-transition
                class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative"
                style="display: none;">
                <span class="block sm:inline" x-text="successMessage"></span>
            </div>

            <!-- NIM / Username -->
            <div>
                <x-input-label for="nim_username" :value="__('NIM')" />
                <div class="flex mt-1">
                    <x-text-input id="nim_username" class="block w-full rounded-r-none" type="text" name="nim_username"
                        x-model="nim" required autofocus autocomplete="username" placeholder="Masukkan NIM Anda" />
                    <button type="button" @click="checkNIM"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :disabled="isLoading">
                        <span x-show="!isLoading">Cek NIM</span>
                        <span x-show="isLoading">Loading...</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('nim_username')" class="mt-2" />
            </div>

            <!-- Nama Lengkap -->
            <div class="mt-4">
                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                <x-text-input id="nama_lengkap" class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="text"
                    name="nama_lengkap" x-model="nama" required readonly autocomplete="name" />
                <p class="text-xs text-gray-500 mt-1">Nama akan terisi otomatis jika NIM terdaftar di Data Master.</p>
                <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
            </div>

            <div x-show="isValidNIM" x-transition style="display: none;">
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4" x-bind:disabled="!isValidNIM">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function nimValidator() {
            return {
                nim: '{{ old("nim_username") }}',
                nama: '{{ old("nama_lengkap") }}',
                isValidNIM: {{ old("nama_lengkap") ? 'true' : 'false' }},
                isLoading: false,
                errorMessage: '',
                successMessage: '',

                init() {
                    // Watch for NIM changes to reset validation state if they type again
                    this.$watch('nim', (value) => {
                        this.isValidNIM = false;
                        this.nama = '';
                        this.errorMessage = '';
                        this.successMessage = '';
                    });
                },

                checkNIM() {
                    if (!this.nim) {
                        this.errorMessage = 'Silakan masukkan NIM terlebih dahulu.';
                        return;
                    }

                    this.isLoading = true;
                    this.errorMessage = '';
                    this.successMessage = '';

                    fetch(`/api/check-nim/${this.nim}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('NIM tidak terdaftar di data Akademik');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.nama = data.data.nama_lengkap;
                                this.isValidNIM = true;
                                this.successMessage = 'NIM valid. Silakan lanjutkan pendaftaran.';
                            }
                        })
                        .catch(error => {
                            this.errorMessage = error.message || 'Terjadi kesalahan saat memeriksa NIM.';
                            this.nama = '';
                            this.isValidNIM = false;
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                }
            }
        }
    </script>
</x-guest-layout>