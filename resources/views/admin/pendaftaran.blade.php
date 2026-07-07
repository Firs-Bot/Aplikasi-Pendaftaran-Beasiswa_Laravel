<x-app-layout>
    <x-slot name="header">Daftar Pendaftaran</x-slot>
    <div class="max-w-7xl mx-auto pb-10" x-data="{ openEdit: false, editData: {} }">
        
        <!-- Filter dan Pencarian -->
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pendaftar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama pendaftar..." class="w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
            </div>
            <div class="w-full md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                <select name="status" class="w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm">
                    <option value="all">Semua Status</option>
                    <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Sedang Ditinjau" {{ request('status') === 'Sedang Ditinjau' ? 'selected' : '' }}>Sedang Ditinjau</option>
                    <option value="Lolos" {{ request('status') === 'Lolos' ? 'selected' : '' }}>Lolos</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full md:w-auto bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-6 rounded-md transition-colors shadow-sm">Filter</button>
            </div>
            @if(request()->has('search') || request()->has('status'))
            <div>
                <a href="{{ route('admin.pendaftaran.index') }}" class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition-colors inline-block text-center">Reset</a>
            </div>
            @endif
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                            <th class="px-6 py-3 font-semibold text-sm">ID</th>
                            <th class="px-6 py-3 font-semibold text-sm">Nama Pendaftar</th>
                            <th class="px-6 py-3 font-semibold text-sm">Beasiswa</th>
                            <th class="px-6 py-3 font-semibold text-sm">Status</th>
                            <th class="px-6 py-3 font-semibold text-sm text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pendaftarans as $pendaftaran)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $pendaftaran->id }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $pendaftaran->nama_lengkap }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $pendaftaran->beasiswa->nama_beasiswa ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $pendaftaran->status_verifikasi }}</td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <button type="button" @click="editData = { id: '{{ $pendaftaran->id }}', nama_lengkap: '{{ addslashes($pendaftaran->nama_lengkap) }}', nim: '{{ addslashes($pendaftaran->nim) }}', email: '{{ addslashes($pendaftaran->email) }}', no_hp: '{{ addslashes($pendaftaran->no_hp) }}', jenis_kelamin: '{{ $pendaftaran->jenis_kelamin }}', jurusan: '{{ addslashes($pendaftaran->jurusan) }}', ipk: '{{ $pendaftaran->ipk }}', penghasilan_ortu: '{{ $pendaftaran->penghasilan_ortu }}', status_verifikasi: '{{ $pendaftaran->status_verifikasi }}', catatan_verifikasi: '{{ addslashes($pendaftaran->catatan_verifikasi ?? '') }}' }; openEdit = true" class="text-blue-500 hover:text-blue-700 text-sm font-medium">Edit</button>
                                
                                <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendaftaran ini? Data tidak bisa dikembalikan.');">
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
                <div x-show="openEdit" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <form :action="'/admin/pendaftaran/' + editData.id" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[80vh] overflow-y-auto">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 border-b pb-2">Edit Pendaftaran Secara Penuh</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Status Verifikasi</label>
                                    <select name="status_verifikasi" x-model="editData.status_verifikasi" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                        <option value="Menunggu">Menunggu</option>
                                        <option value="Sedang Ditinjau">Sedang Ditinjau</option>
                                        <option value="Lolos">Lolos</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Catatan Verifikasi</label>
                                    <input type="text" name="catatan_verifikasi" x-model="editData.catatan_verifikasi" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700">
                                </div>
                            </div>

                            <h4 class="font-bold text-gray-800 mt-6 mb-2 border-b pb-1">Data Diri Mahasiswa</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" x-model="editData.nama_lengkap" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">NIM</label>
                                    <input type="text" name="nim" x-model="editData.nim" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                    <input type="email" name="email" x-model="editData.email" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">No. HP</label>
                                    <input type="text" name="no_hp" x-model="editData.no_hp" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" x-model="editData.jenis_kelamin" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                                    <input type="text" name="jurusan" x-model="editData.jurusan" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">IPK</label>
                                    <input type="number" step="0.01" min="0" max="4" name="ipk" x-model="editData.ipk" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Penghasilan Orang Tua</label>
                                    <select name="penghasilan_ortu" x-model="editData.penghasilan_ortu" class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700" required>
                                        <option value="< 500000">< Rp 500.000</option>
                                        <option value="500000 - 1000000">Rp 500.000 - Rp 1.000.000</option>
                                        <option value="1000000 - 1500000">Rp 1.000.000 - Rp 1.500.000</option>
                                        <option value="1500000 - 2000000">Rp 1.500.000 - Rp 2.000.000</option>
                                        <option value="> 2000000">> Rp 2.000.000</option>
                                    </select>
                                </div>
                            </div>

                            <h4 class="font-bold text-gray-800 mt-6 mb-2 border-b pb-1">Timpa Berkas Pendaftaran <span class="text-xs font-normal text-gray-500">(Format: PDF, Kosongkan jika tidak ada perubahan)</span></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">Surat Pernyataan / Lampiran Utama</label>
                                    <input type="file" name="file_lampiran" accept=".pdf" class="text-sm w-full">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">Surat Aktif Kuliah</label>
                                    <input type="file" name="surat_aktif" accept=".pdf" class="text-sm w-full">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">KTP</label>
                                    <input type="file" name="ktp" accept=".pdf" class="text-sm w-full">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">KTM</label>
                                    <input type="file" name="ktm" accept=".pdf" class="text-sm w-full">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">KRS</label>
                                    <input type="file" name="krs" accept=".pdf" class="text-sm w-full">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm mb-1">Surat Tidak Menerima Beasiswa Lain</label>
                                    <input type="file" name="surat_sktm" accept=".pdf" class="text-sm w-full">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="openEdit = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
