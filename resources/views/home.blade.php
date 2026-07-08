<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Beasiswa UNIKU - Universitas Kuningan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-uniku.png') }}" alt="Logo UNIKU" class="w-10 h-10 object-contain">
                        <span class="font-bold text-xl text-gray-900 tracking-tight">UNIVERSITAS KUNINGAN</span>
                    </div>
                    <nav class="flex gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="font-semibold text-gray-600 hover:text-yellow-600 px-4 py-2">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-yellow-600 px-4 py-2">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-semibold bg-yellow-500 text-gray-900 rounded-lg px-4 py-2 hover:bg-yellow-700 transition-colors">Register</a>
                                @endif
                            @endauth
                        @endif
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <div class="relative bg-gradient-to-br from-yellow-600 to-yellow-700 overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center relative z-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                        Wujudkan Mimpimu <br/>
                        <span class="text-yellow-400">Bersama Beasiswa UNIKU</span>
                    </h1>
                    <p class="max-w-2xl text-lg md:text-xl text-yellow-100 mb-10">
                        Kami mendukung penuh prestasi dan semangat belajarmu. Dapatkan akses beasiswa terbaik yang ditawarkan oleh Universitas Kuningan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-400 text-indigo-900 font-bold rounded-xl hover:bg-yellow-300 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 w-full sm:w-auto">
                            Daftar Sekarang
                        </a>
                        <a href="#pengumuman" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 transition-all w-full sm:w-auto">
                            Lihat Pengumuman
                        </a>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20 pointer-events-none">
                    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-yellow-500 blur-3xl"></div>
                    <div class="absolute bottom-10 right-10 w-64 h-64 rounded-full bg-yellow-400 blur-3xl"></div>
                </div>
            </div>

            <section id="pengumuman" class="py-20 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">PENGUMUMAN TERBARU</h2>
                        <div class="mt-4 w-24 h-1.5 bg-yellow-400 mx-auto rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($pengumuman as $p)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full group" x-data="{ open: false }">
                            <div class="relative h-56 overflow-hidden">
                                @if($p->gambar)
                                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-medium">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-yellow-700 shadow-sm">
                                    {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">{{ $p->judul }}</h3>
                                <p class="text-gray-600 mb-6 flex-1 line-clamp-3 text-sm leading-relaxed">{{ $p->isi }}</p>
                                
                                <button @click="open = true" class="mt-auto w-full bg-yellow-50 text-yellow-700 px-4 py-3 rounded-xl font-semibold hover:bg-yellow-100 transition-colors flex items-center justify-center gap-2">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>

                            <!-- Modal -->
                            <div x-show="open" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="open = false"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="open" x-transition class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full w-full mx-4">
                                        <div class="bg-yellow-600 px-6 py-4 flex justify-between items-center">
                                            <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">{{ $p->judul }}</h3>
                                            <button @click="open = false" class="text-yellow-200 hover:text-white transition-colors">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        <div class="bg-white px-6 py-6 sm:p-8">
                                            <div class="text-sm text-yellow-600 font-semibold mb-6">Dipublikasikan: {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</div>
                                            @if($p->gambar)
                                                <div class="mb-8 rounded-xl overflow-hidden shadow-sm">
                                                    <img class="w-full h-auto max-h-[400px] object-cover" src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}">
                                                </div>
                                            @endif
                                            <div class="prose prose-indigo max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $p->isi }}</div>
                                        </div>
                                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                            <button type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors" @click="open = false">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center shadow-sm">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pengumuman</h3>
                            <p class="text-gray-500">Belum ada pengumuman yang dipublikasikan saat ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
        
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Universitas Kuningan. All rights reserved.
            </div>
        </footer>
    </body>
</html>
