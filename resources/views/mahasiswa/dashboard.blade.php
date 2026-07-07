<x-app-layout>
    <x-slot name="header">
        Dashboard Mahasiswa
    </x-slot>

    <!-- Notifikasi Status Pendaftaran Terkini -->
    @if($pendaftarans->count() > 0)
        @php
            $latest = $pendaftarans->first();
            $alertColor = 'bg-gray-100 border-gray-200 text-gray-800';
            if($latest->status_verifikasi == 'MENUNGGU' || $latest->status_verifikasi == 'SEDANG DITINJAU') $alertColor = 'bg-yellow-50 border-yellow-200 text-yellow-800';
            if($latest->status_verifikasi == 'LOLOS') $alertColor = 'bg-green-50 border-green-200 text-green-800';
            if($latest->status_verifikasi == 'DITOLAK') $alertColor = 'bg-red-50 border-red-200 text-red-800';
        @endphp
        <div class="mb-8 border rounded-xl p-4 flex items-start gap-4 shadow-sm {{ $alertColor }}">
            <div class="mt-1">
                @if($latest->status_verifikasi == 'LOLOS')
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @elseif($latest->status_verifikasi == 'DITOLAK')
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @else
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
            </div>
            <div>
                <h4 class="font-bold">Status Pendaftaran Terakhir: {{ $latest->beasiswa->nama_beasiswa }}</h4>
                <p class="text-sm mt-1">Status verifikasi saat ini: <strong>{{ $latest->status_verifikasi }}</strong></p>
                @if($latest->status_verifikasi == 'MENUNGGU')
                    <p class="text-sm mt-1 opacity-80">Berkas Anda sedang menunggu giliran untuk diverifikasi oleh admin.</p>
                @endif
            </div>
        </div>
    @endif

    <div x-data="{
        registerOpen: false,
        selectedBeasiswaId: '',
        selectedBeasiswaName: '',
        openRegisterModal(id, name) {
            this.selectedBeasiswaId = id;
            this.selectedBeasiswaName = name;
            this.registerOpen = true;
        }
    }">
        <!-- Pilihan Beasiswa dalam bentuk Card -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Beasiswa Tersedia</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($beasiswas as $b)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-200">
                        <div class="h-48 bg-gray-100 relative">
                            @if($b->foto)
                                <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_beasiswa }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-50 to-blue-50">
                                    <svg class="w-16 h-16 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-yellow-700 shadow-sm">
                                {{ $b->penyedia }}
                            </div>
                        </div>
                        <div class="p-6 flex flex-col h-[calc(100%-12rem)]">
                            <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight">{{ $b->nama_beasiswa }}</h4>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4 font-medium">
                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Diposting: {{ $b->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-6 line-clamp-3 flex-grow">{{ $b->deskripsi }}</p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                @if($pendaftarans->whereIn('status_verifikasi', ['MENUNGGU', 'SEDANG DITINJAU'])->count() > 0)
                                    <button type="button" class="w-full bg-gray-100 text-gray-400 py-2.5 rounded-lg font-medium text-sm cursor-not-allowed" disabled>Sedang Memiliki Antrean Verifikasi</button>
                                @else
                                    <button type="button" @click="openRegisterModal('{{ $b->id }}', '{{ addslashes($b->nama_beasiswa) }}')" class="w-full bg-yellow-500 hover:bg-yellow-600 text-gray-900 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm flex justify-center items-center gap-2">
                                        Daftar Beasiswa Ini
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 border border-gray-100 rounded-xl p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Beasiswa Tersedia</h3>
                        <p class="text-gray-500">Saat ini tidak ada program beasiswa yang sedang dibuka. Harap cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Riwayat (Dihapus, Pindah ke Halaman Tersendiri) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Spasi atau info lain bisa ditaruh di sini nantinya -->
            </div>
            
            <!-- Kolom Kanan: Info -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-xl shadow-md p-6 text-white">
                    <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Pusat Bantuan
                    </h3>
                    <p class="text-sm text-yellow-100 mb-4 leading-relaxed">Mengalami kendala saat melengkapi berkas pendaftaran? Tim layanan akademik kami siap membantu Anda.</p>
                    <a href="#" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-yellow-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition-colors w-full shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Hubungi Bantuan
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Pendaftaran Baru -->
        <div x-show="registerOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
                <div x-show="registerOpen" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="registerOpen = false"></div>
                
                <div x-show="registerOpen" class="relative inline-block w-full max-w-2xl overflow-hidden align-middle transition-all transform bg-white rounded-2xl shadow-xl">
                    <div class="px-6 py-4 border-b border-gray-100 bg-yellow-600 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Formulir Pendaftaran
                        </h3>
                        <button type="button" @click="registerOpen = false" class="text-yellow-100 hover:text-white transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <form action="{{ route('mhs.pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Hidden Input untuk Beasiswa ID -->
                        <input type="hidden" name="beasiswa_id" x-model="selectedBeasiswaId">

                        <div class="p-6 max-h-[75vh] overflow-y-auto">
                            
                            <div class="mb-6 bg-yellow-50 border border-yellow-100 rounded-lg p-4 flex gap-3">
                                <svg class="w-6 h-6 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-bold text-indigo-900">Beasiswa yang Dipilih:</h4>
                                    <p class="text-sm text-yellow-700" x-text="selectedBeasiswaName"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                                    <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full bg-gray-50" :value="auth()->user()->nama_lengkap" readonly />
                                </div>
                                
                                <div>
                                    <x-input-label for="nim" value="NIM" />
                                    <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full bg-gray-50" :value="auth()->user()->nim_username" readonly />
                                </div>

                                <div>
                                    <x-input-label for="email" value="Email Aktif" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                                </div>
                                
                                <div>
                                    <x-input-label for="no_hp" value="No. HP / WhatsApp" />
                                    <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" required />
                                </div>

                                <div>
                                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-md shadow-sm" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="jurusan" value="Program Studi / Jurusan" />
                                    <!-- Jika Master Mahasiswa memiliki jurusan, kita bisa isikan di sini, tetapi karena tidak ditarik dari Auth, biarkan form input atau tarik jika ada -->
                                    <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full" required />
                                </div>
                                
                                <div class="md:col-span-2">
                                    <x-input-label for="ipk" value="IPK Terakhir" />
                                    <x-text-input id="ipk" name="ipk" type="number" step="0.01" min="0" max="4" class="mt-1 block w-full md:w-1/2" required />
                                </div>
                            </div>

                            <div class="bg-gray-50 -mx-6 px-6 py-4 border-t border-b border-gray-100">
                                <h4 class="font-bold text-gray-900 mb-4">Upload Berkas Persyaratan (Wajib PDF, Maks 2MB)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <x-input-label for="sktm" value="Surat Ket. Tidak Mampu" />
                                        <input type="file" id="sktm" name="sktm" accept="application/pdf" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
                                    </div>
                                    <div>
                                        <x-input-label for="rekomendasi" value="Surat Rekomendasi" />
                                        <input type="file" id="rekomendasi" name="rekomendasi" accept="application/pdf" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
                                    </div>
                                    <div>
                                        <x-input-label for="transkrip" value="Transkrip Nilai" />
                                        <input type="file" id="transkrip" name="transkrip" accept="application/pdf" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl border-t border-gray-100">
                            <button type="button" @click="registerOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                            <x-primary-button class="py-2 px-6">Submit Pendaftaran</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
