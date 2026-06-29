<x-app-layout>
    <x-slot name="header">
        Riwayat Pendaftaran
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Daftar Riwayat Anda
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($pendaftarans as $p)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-indigo-700">{{ $p->beasiswa->nama_beasiswa }}</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                {{ $p->status_verifikasi == 'LOLOS' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $p->status_verifikasi == 'DITOLAK' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $p->status_verifikasi == 'SEDANG DITINJAU' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $p->status_verifikasi == 'MENUNGGU' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ $p->status_verifikasi }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500 mb-4">Didaftar pada: {{ $p->created_at->translatedFormat('d M Y, H:i') }} WIB</div>
                        
                        @if(in_array($p->status_verifikasi, ['MENUNGGU']))
                        <!-- Edit Pendaftaran -->
                        <div x-data="{ editOpen: false }">
                            <button @click="editOpen = true" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> 
                                Perbarui Berkas/Data
                            </button>
                            
                            <!-- Modal Edit -->
                            <div x-show="editOpen" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
                                    <div x-show="editOpen" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="editOpen = false"></div>
                                    
                                    <div x-show="editOpen" class="relative inline-block w-full max-w-2xl overflow-hidden align-middle transition-all transform bg-white rounded-2xl shadow-xl text-left">
                                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                            <h3 class="text-lg font-bold text-gray-900">Perbarui Pendaftaran: {{ $p->beasiswa->nama_beasiswa }}</h3>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-gray-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                        </div>
                                        <form action="{{ route('mhs.pendaftaran.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                                                <div>
                                                    <x-input-label for="edit_nama_lengkap_{{ $p->id }}" value="Nama Lengkap" />
                                                    <x-text-input id="edit_nama_lengkap_{{ $p->id }}" name="nama_lengkap" type="text" class="mt-1 block w-full bg-gray-50" :value="$p->nama_lengkap" readonly />
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <x-input-label for="edit_ipk_{{ $p->id }}" value="IPK" />
                                                        <x-text-input id="edit_ipk_{{ $p->id }}" name="ipk" type="number" step="0.01" min="0" max="4" class="mt-1 block w-full" :value="$p->ipk" required />
                                                    </div>
                                                    <div>
                                                        <x-input-label for="edit_no_hp_{{ $p->id }}" value="No HP" />
                                                        <x-text-input id="edit_no_hp_{{ $p->id }}" name="no_hp" type="text" class="mt-1 block w-full" :value="$p->no_hp" required />
                                                    </div>
                                                </div>
                                                <div>
                                                    <x-input-label for="edit_email_{{ $p->id }}" value="Email Aktif" />
                                                    <x-text-input id="edit_email_{{ $p->id }}" name="email" type="email" class="mt-1 block w-full" :value="$p->email" required />
                                                </div>
                                                
                                                <div class="bg-yellow-50 p-4 rounded-lg text-sm text-yellow-800 border border-yellow-100">
                                                    <div class="flex gap-2">
                                                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <span>Kosongkan input file di bawah ini jika tidak ingin mengubah berkas yang sudah Anda unggah sebelumnya.</span>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <x-input-label for="edit_sktm_{{ $p->id }}" value="Surat Ket. Tidak Mampu Baru (PDF, Maks 2MB)" />
                                                    <input type="file" id="edit_sktm_{{ $p->id }}" name="sktm" accept="application/pdf" class="mt-1 block w-full text-sm">
                                                </div>
                                                <div>
                                                    <x-input-label for="edit_rekomendasi_{{ $p->id }}" value="Surat Rekomendasi Baru (PDF, Maks 2MB)" />
                                                    <input type="file" id="edit_rekomendasi_{{ $p->id }}" name="rekomendasi" accept="application/pdf" class="mt-1 block w-full text-sm">
                                                </div>
                                                <div>
                                                    <x-input-label for="edit_transkrip_{{ $p->id }}" value="Transkrip Nilai Baru (PDF, Maks 2MB)" />
                                                    <input type="file" id="edit_transkrip_{{ $p->id }}" name="transkrip" accept="application/pdf" class="mt-1 block w-full text-sm">
                                                </div>
                                            </div>
                                            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl border-t border-gray-100">
                                                <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                                                <x-primary-button>Update Data</x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Belum ada riwayat pendaftaran.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
