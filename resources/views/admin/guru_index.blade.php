<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy">👨‍🏫 Manajemen Guru</h2>
            <a href="{{ route('admin.guru.create') }}" class="bg-navy hover:bg-opacity-90 text-white px-4 py-2 rounded-xl font-semibold">+ Tambah Guru</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-baby-blue">
                            <tr>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">No</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Nama</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Email</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guru as $g)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-800 font-medium">{{ $g->name }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-600">{{ $g->email }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    <button onclick="if(confirm('Yakin hapus {{ $g->name }}?')) window.location.href='{{ route('admin.guru.destroy', $g->id) }}'" class="text-red-500 hover:text-red-700 font-medium">🗑️ Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="border px-4 py-8 text-center text-gray-500">Belum ada data guru</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t">{{ $guru->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>