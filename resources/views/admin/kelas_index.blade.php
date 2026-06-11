<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy">🏫 Manajemen Kelas</h2>
            <a href="{{ route('admin.kelas.create') }}" class="bg-navy hover:bg-opacity-90 text-white px-4 py-2 rounded-xl font-semibold">+ Tambah Kelas</a>
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
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Nama Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Tingkat</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Tahun Ajaran</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Wali Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Jml Siswa</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $k)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3 font-medium text-gray-800">{{ $k->nama_kelas }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $k->tingkat }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $k->tahun_ajaran }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $k->waliKelas->name ?? '-' }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-center text-gray-700">{{ $k->siswa_count }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    <a href="{{ route('admin.kelas.edit', $k->id) }}" class="text-navy hover:text-baby-blue mr-3 font-medium">Edit</a>
                                    <button onclick="if(confirm('Yakin hapus {{ $k->nama_kelas }}?')) window.location.href='{{ route('admin.kelas.destroy', $k->id) }}'" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t">{{ $kelas->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>