<x-app-layout>
    <x-slot name="header">
        Verifikasi Pendaftaran
    </x-slot>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 p-4">
        <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900">Data Pendaftar Beasiswa</h3>
            <div class="flex items-center gap-3">
                <label for="filter" class="font-medium text-gray-700 text-sm">Filter Status:</label>
                <select name="filter" id="filter" class="border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="MENUNGGU" {{ $filter === 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                    <option value="SEDANG DITINJAU" {{ $filter === 'SEDANG DITINJAU' ? 'selected' : '' }}>Sedang Ditinjau</option>
                    <option value="LOLOS" {{ $filter === 'LOLOS' ? 'selected' : '' }}>Lolos</option>
                    <option value="DITOLAK" {{ $filter === 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <a href="{{ route('admin.pendaftaran.pdf', ['filter' => $filter]) }}" target="_blank" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-md text-sm font-semibold shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Table Pendaftar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold text-sm">Nama Pendaftar</th>
                        <th class="px-6 py-4 font-semibold text-sm">Beasiswa</th>
                        <th class="px-6 py-4 font-semibold text-sm">Jurusan / IPK</th>
                        <th class="px-6 py-4 font-semibold text-sm text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftarans as $p)
                        @php
                            $badgeColor = 'bg-gray-100 text-gray-800';
                            if($p->status_verifikasi == 'SEDANG DITINJAU') $badgeColor = 'bg-yellow-100 text-yellow-800';
                            if($p->status_verifikasi == 'LOLOS') $badgeColor = 'bg-green-100 text-green-800';
                            if($p->status_verifikasi == 'DITOLAK') $badgeColor = 'bg-red-100 text-red-800';
                        @endphp
                        <tr x-data="{ modalOpen: false }" class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $p->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $p->nim }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $p->beasiswa->nama_beasiswa }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $p->jurusan }}</div>
                                <div class="text-xs font-bold text-yellow-600">IPK: {{ $p->ipk }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                                    {{ $p->status_verifikasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button @click="modalOpen = true" class="text-yellow-600 hover:text-indigo-900 bg-yellow-50 hover:bg-yellow-100 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                    Verifikasi Berkas
                                </button>

                                <!-- Modal Verifikasi -->
                                <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto text-left" style="display: none;">
                                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
                                        <div x-show="modalOpen" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="modalOpen = false"></div>
                                        
                                        <div x-show="modalOpen" class="relative inline-block w-full max-w-3xl overflow-hidden align-middle transition-all transform bg-white rounded-2xl shadow-xl">
                                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                                <h3 class="text-lg font-bold text-gray-900">Detail Verifikasi: <span class="text-yellow-600">{{ $p->nama_lengkap }}</span></h3>
                                                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </div>
                                            
                                            <div class="p-6">
                                                <!-- Info Pribadi -->
                                                <div class="bg-gray-50 rounded-xl p-5 mb-6 grid grid-cols-2 md:grid-cols-4 gap-4 border border-gray-100">
                                                    <div>
                                                        <div class="text-xs text-gray-500 mb-1">NIM</div>
                                                        <div class="font-semibold text-gray-900">{{ $p->nim }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500 mb-1">IPK</div>
                                                        <div class="font-bold text-yellow-600">{{ $p->ipk }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500 mb-1">Email</div>
                                                        <div class="font-semibold text-gray-900 text-sm truncate" title="{{ $p->email }}">{{ $p->email }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500 mb-1">No HP</div>
                                                        <div class="font-semibold text-gray-900 text-sm">{{ $p->no_hp }}</div>
                                                    </div>
                                                </div>

                                                <!-- Dokumen Lampiran -->
                                                <h4 class="font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">Lampiran Berkas</h4>
                                                <div class="flex flex-wrap gap-3 mb-8">
                                                    <a href="{{ asset('storage/' . $p->file_sktm) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> SKTM
                                                    </a>
                                                    <a href="{{ asset('storage/' . $p->file_rekomendasi) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Rekomendasi
                                                    </a>
                                                    <a href="{{ asset('storage/' . $p->file_transkrip) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Transkrip
                                                    </a>
                                                </div>

                                                <!-- Aksi Verifikasi -->
                                                <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 text-center">
                                                    @if(in_array($p->status_verifikasi, ['LOLOS', 'DITOLAK']))
                                                        <div class="inline-flex items-center justify-center p-4 rounded-lg bg-gray-100 w-full text-gray-700">
                                                            <div>Status verifikasi sudah final: <strong class="{{ $p->status_verifikasi == 'LOLOS' ? 'text-green-600' : 'text-red-600' }}">{{ $p->status_verifikasi }}</strong>.<br><span class="text-sm">Data tidak dapat diubah lagi.</span></div>
                                                        </div>
                                                    @else
                                                        <p class="font-bold text-gray-900 mb-4">Tentukan Keputusan Status:</p>
                                                        <form action="{{ route('admin.pendaftaran.update', $p->id) }}" method="POST" class="flex flex-wrap justify-center gap-3">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" name="status_verifikasi" value="SEDANG DITINJAU" class="px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-bold shadow-sm transition-colors">⚠️ Sedang Ditinjau</button>
                                                            <button type="submit" name="status_verifikasi" value="LOLOS" class="px-6 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg font-bold shadow-sm transition-colors" onclick="return confirm('Yakin memberikan status LOLOS? Ini bersifat final.')">✅ LOLOS</button>
                                                            <button type="submit" name="status_verifikasi" value="DITOLAK" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-bold shadow-sm transition-colors" onclick="return confirm('Yakin memberikan status DITOLAK? Ini bersifat final.')">❌ DITOLAK</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
