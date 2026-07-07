<x-app-layout>
    <x-slot name="header">
        Kelola Beasiswa
    </x-slot>

    <!-- Form Tambah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8" x-data="{ open: false }">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 cursor-pointer" @click="open = !open">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Beasiswa Baru
            </h3>
            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        
        <div x-show="open" class="p-6" x-transition>
            <form action="{{ route('baak.beasiswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <x-input-label for="nama_beasiswa" value="Nama Beasiswa" />
                        <x-text-input id="nama_beasiswa" name="nama_beasiswa" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="penyedia" value="Penyedia" />
                        <x-text-input id="penyedia" name="penyedia" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="deskripsi" value="Deskripsi" />
                        <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm" required></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="foto" value="Foto Banner (Opsional)" />
                        <input id="foto" name="foto" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-primary-button>Simpan Beasiswa</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Beasiswa -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($beasiswas as $b)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full" x-data="{ editOpen: false }">
                @if($b->foto)
                    <img src="{{ asset('storage/' . $b->foto) }}" alt="Banner" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                @endif
                
                <div class="p-5 flex-1 flex flex-col">
                    <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $b->nama_beasiswa }}</h4>
                    <p class="text-sm font-medium text-yellow-600 mb-3">{{ $b->penyedia }}</p>
                    <p class="text-gray-600 text-sm flex-1 mb-4">{{ Str::limit($b->deskripsi, 100) }}</p>
                    
                    <div class="flex gap-2 mt-auto pt-4 border-t border-gray-100">
                        <button @click="editOpen = true" class="flex-1 bg-yellow-50 text-yellow-700 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-100 transition-colors text-center">Edit</button>
                        <form action="{{ route('baak.beasiswa.destroy', $b->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus beasiswa ini? Pendaftar terkait akan ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-700 py-2 rounded-lg text-sm font-semibold hover:bg-red-100 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div x-show="editOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="editOpen" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="editOpen = false"></div>
                        
                        <div x-show="editOpen" class="relative inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-900">Edit Beasiswa</h3>
                                <button @click="editOpen = false" class="text-gray-400 hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </div>
                            <form action="{{ route('baak.beasiswa.update', $b->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="nama_beasiswa_{{ $b->id }}" value="Nama Beasiswa" />
                                        <x-text-input id="nama_beasiswa_{{ $b->id }}" name="nama_beasiswa" type="text" class="mt-1 block w-full" :value="$b->nama_beasiswa" required />
                                    </div>
                                    <div>
                                        <x-input-label for="penyedia_{{ $b->id }}" value="Penyedia" />
                                        <x-text-input id="penyedia_{{ $b->id }}" name="penyedia" type="text" class="mt-1 block w-full" :value="$b->penyedia" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-input-label for="deskripsi_{{ $b->id }}" value="Deskripsi" />
                                        <textarea id="deskripsi_{{ $b->id }}" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm" required>{{ $b->deskripsi }}</textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-input-label for="foto_{{ $b->id }}" value="Ganti Foto (Opsional)" />
                                        <input id="foto_{{ $b->id }}" name="foto" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" />
                                    </div>
                                </div>
                                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                                    <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                                    <x-primary-button>Simpan Perubahan</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-12 bg-white rounded-xl shadow-sm border border-gray-100 text-center">
                <p class="text-gray-500">Belum ada data beasiswa.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
