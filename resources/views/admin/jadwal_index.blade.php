<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy">📅 Manajemen Jadwal</h2>
            <a href="{{ route('admin.jadwal.create') }}" class="bg-navy hover:bg-opacity-90 text-white px-4 py-2 rounded-xl font-semibold">+ Tambah Jadwal</a>
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
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Hari</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Mata Pelajaran</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Guru</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Jam</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-navy font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwal as $j)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3"><span class="bg-baby-blue text-navy px-2 py-1 rounded-full text-xs font-semibold">{{ $j->hari }}</span></td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                                <td class="border border-gray-200 px-4 py-3 font-medium text-gray-800">{{ $j->mata_pelajaran }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $j->guru->name ?? '-' }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="text-navy hover:text-baby-blue mr-3 font-medium">Edit</a>
                                    <button onclick="if(confirm('Yakin hapus?')) window.location.href='{{ route('admin.jadwal.destroy', $j->id) }}'" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t">{{ $jadwal->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>