<x-app-layout>
    <x-slot name="header">Super Admin Dashboard</x-slot>
    <div class="max-w-7xl mx-auto space-y-6 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                <span class="text-sm text-gray-500 font-medium">Total Pengguna</span>
                <span class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['users'] }}</span>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                <span class="text-sm text-gray-500 font-medium">Total Beasiswa</span>
                <span class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['beasiswas'] }}</span>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                <span class="text-sm text-gray-500 font-medium">Total Pengumuman</span>
                <span class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pengumumans'] }}</span>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                <span class="text-sm text-gray-500 font-medium">Total Pendaftaran</span>
                <span class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pendaftarans'] }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
