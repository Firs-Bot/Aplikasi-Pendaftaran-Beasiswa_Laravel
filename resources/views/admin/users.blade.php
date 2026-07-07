<x-app-layout>
    <x-slot name="header">Daftar Pengguna (Super Admin)</x-slot>
    <div class="max-w-7xl mx-auto pb-10">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 border-b border-gray-200">
                            <th class="px-6 py-3 font-semibold text-sm">ID</th>
                            <th class="px-6 py-3 font-semibold text-sm">Nama Lengkap</th>
                            <th class="px-6 py-3 font-semibold text-sm">NIM / Username</th>
                            <th class="px-6 py-3 font-semibold text-sm">Role</th>
                            <th class="px-6 py-3 font-semibold text-sm text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $user->nama_lengkap }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $user->nim_username }}</td>
                            <td class="px-6 py-3 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold 
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'baak' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                                </form>
                                @else
                                <span class="text-gray-400 text-sm">Super Admin</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
