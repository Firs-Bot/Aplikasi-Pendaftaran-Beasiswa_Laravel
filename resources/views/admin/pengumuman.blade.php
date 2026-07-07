<x-app-layout>
    <x-slot name="header">Daftar Pengumuman (Super Admin)</x-slot>
    <div class="max-w-7xl mx-auto pb-10" x-data="{ openEdit: false, editData: {} }">
        
        <!-- Pencarian -->
        <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pengumuman</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik judul pengumuman..." class="w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            </div>
            <div>
                <button type="submit" class="w-full md:w-auto bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-6 rounded-md transition-colors shadow-sm">Cari</button>
            </div>
            @if(request()->has('search'))
            <div>
                <a href="{{ route('admin.pengumuman.index') }}" class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors inline-block text-center">Reset</a>
            </div>
            @endif
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                            <th class="px-6 py-3 font-semibold text-sm">ID</th>
                            <th class="px-6 py-3 font-semibold text-sm">Judul Pengumuman</th>
                            <th class="px-6 py-3 font-semibold text-sm">Tanggal Buat</th>
                            <th class="px-6 py-3 font-semibold text-sm text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pengumumans as $pengumuman)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $pengumuman->id }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $pengumuman->judul }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $pengumuman->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <button type="button" @click="editData = { id: '{{ $pengumuman->id }}', judul: '{{ addslashes($pengumuman->judul) }}', isi: '{{ addslashes(str_replace(array("\r", "\n"), array("\\r", "\\n"), $pengumuman->isi)) }}' }; openEdit = true" class="text-blue-500 hover:text-blue-700 text-sm font-medium">Edit</button>
                                
                                <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="openEdit" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="openEdit = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div x-show="openEdit" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <form :action="'/admin/pengumuman/' + editData.id" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Pengumuman</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Pengumuman</label>
                                <input type="text" name="judul" x-model="editData.judul" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500 focus:ring-yellow-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Konten / Isi</label>
                                <textarea name="isi" x-model="editData.isi" rows="6" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500 focus:ring-yellow-500" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="file" name="gambar" accept="image/*" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-yellow-500 focus:ring-yellow-500">
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="openEdit = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
