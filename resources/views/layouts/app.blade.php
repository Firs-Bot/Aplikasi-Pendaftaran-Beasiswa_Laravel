<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Beasiswa UNIKU') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 flex overflow-hidden h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full hidden md:flex shrink-0 shadow-sm z-10">
            <div class="h-16 flex items-center px-6 border-b border-gray-200 bg-yellow-600">
                <a href="/" class="text-xl font-bold text-white flex items-center gap-2">
                    <img src="{{ asset('images/logo-uniku.png') }}" alt="Logo UNIKU" class="w-8 h-8 object-contain bg-white rounded p-0.5">
                    Beasiswa UNIKU
                </a>
            </div>
            
            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard Admin</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Data Pengguna</a>
                    <a href="{{ route('admin.beasiswa.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.beasiswa.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Data Beasiswa</a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Data Pengumuman</a>
                    <a href="{{ route('admin.pendaftaran.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Data Pendaftaran</a>
                @elseif(auth()->user()->role === 'baak')
                    <a href="{{ route('baak.dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('baak.dashboard') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard BAAK</a>
                    <a href="{{ route('baak.beasiswa.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('baak.beasiswa.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Kelola Beasiswa</a>
                    <a href="{{ route('baak.pengumuman.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('baak.pengumuman.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Kelola Pengumuman</a>
                    <a href="{{ route('baak.pendaftaran.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('baak.pendaftaran.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Pendaftar & Verifikasi</a>
                @else
                    <a href="{{ route('mhs.dashboard') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mhs.dashboard') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard</a>
                    <a href="{{ route('mhs.pendaftaran.index') }}" class="block px-4 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mhs.pendaftaran.*') ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100' }}">Riwayat Pendaftaran</a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Topbar -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 shrink-0 z-10">
                <div class="flex items-center">
                    <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 rounded-md p-2 mr-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    @isset($header)
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $header }}
                        </h2>
                    @endisset
                </div>
                
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->nama_lengkap }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->role === 'mahasiswa')
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-sm flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-sm flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
