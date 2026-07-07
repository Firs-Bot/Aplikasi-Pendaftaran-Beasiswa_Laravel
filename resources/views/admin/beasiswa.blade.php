<x-app-layout>
    <x-slot name="header">Daftar Beasiswa (Super Admin)</x-slot>
    <div class="max-w-7xl mx-auto pb-10">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                            <th class="px-6 py-3 font-semibold text-sm">ID</th>
                            <th class="px-6 py-3 font-semibold text-sm">Nama Beasiswa</th>
                            <th class="px-6 py-3 font-semibold text-sm">Penyedia</th>
                            <th class="px-6 py-3 font-semibold text-sm text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($beasiswas as $beasiswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $beasiswa->id }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $beasiswa->nama_beasiswa }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $beasiswa->penyedia }}</td>
                            <td class="px-6 py-3 text-center">
                                <form action="{{ route('admin.beasiswa.destroy', $beasiswa->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus beasiswa ini? Semua pendaftaran terkait juga bisa terhapus.');">
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
    </div>
</x-app-layout>
