<x-app-layout>
    <x-slot name="header">
        Kelola Pengumuman
    </x-slot>

    <!-- Form Tambah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8" x-data="{ open: false }">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 cursor-pointer" @click="open = !open">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Buat Pengumuman Baru
            </h3>
            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        
        <div x-show="open" class="p-6" x-transition>
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <x-input-label for="judul" value="Judul Pengumuman" />
                        <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="isi" value="Isi / Detail" />
                        <textarea id="isi" name="isi" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                    </div>
                    <div>
                        <x-input-label for="gambar" value="Poster Gambar (Opsional)" />
                        <input id="gambar" name="gambar" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-primary-button>Posting Pengumuman</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold text-sm">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-sm">Poster</th>
                        <th class="px-6 py-4 font-semibold text-sm">Judul</th>
                        <th class="px-6 py-4 font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengumumen as $p)
                        <tr x-data="{ editOpen: false }" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="Poster" class="h-12 w-20 object-cover rounded shadow-sm">
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $p->judul }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="editOpen = true" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 px-3 py-1.5 rounded-md text-sm font-medium transition-colors">Edit</button>
                                    <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md text-sm font-medium transition-colors">Hapus</button>
                                    </form>
                                </div>

                                <!-- Edit Modal -->
                                <div x-show="editOpen" class="fixed inset-0 z-50 overflow-y-auto text-left" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
                                        <div x-show="editOpen" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="editOpen = false"></div>
                                        
                                        <div x-show="editOpen" class="relative inline-block w-full max-w-2xl overflow-hidden align-middle transition-all transform bg-white rounded-2xl shadow-xl">
                                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                                <h3 class="text-lg font-bold text-gray-900">Edit Pengumuman</h3>
                                                <button @click="editOpen = false" class="text-gray-400 hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </div>
                                            <form action="{{ route('admin.pengumuman.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="p-6 space-y-4">
                                                    <div>
                                                        <x-input-label for="judul_{{ $p->id }}" value="Judul" />
                                                        <x-text-input id="judul_{{ $p->id }}" name="judul" type="text" class="mt-1 block w-full" :value="$p->judul" required />
                                                    </div>
                                                    <div>
                                                        <x-input-label for="isi_{{ $p->id }}" value="Isi" />
                                                        <textarea id="isi_{{ $p->id }}" name="isi" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $p->isi }}</textarea>
                                                    </div>
                                                    <div>
                                                        <x-input-label for="gambar_{{ $p->id }}" value="Ganti Poster (Opsional)" />
                                                        <input id="gambar_{{ $p->id }}" name="gambar" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                                    </div>
                                                </div>
                                                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl border-t border-gray-100">
                                                    <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                                                    <x-primary-button>Simpan Perubahan</x-primary-button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada pengumuman yang dipublikasikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
