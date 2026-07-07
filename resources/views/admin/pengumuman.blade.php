<x-app-layout>
    <x-slot name="header">Daftar Pengumuman (Super Admin)</x-slot>
    <div class="max-w-7xl mx-auto pb-10">
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
                            <td class="px-6 py-3 text-center">
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
    </div>
</x-app-layout>
