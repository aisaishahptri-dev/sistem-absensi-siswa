<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Kelas
            </h2>
            <a href="{{ route('admin.kelas.create') }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Kelas
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-3 text-left">No</th>
                                    <th class="border p-3 text-left">Nama Kelas</th>
                                    <th class="border p-3 text-left">Tingkat</th>
                                    <th class="border p-3 text-left">Tahun Ajaran</th>
                                    <th class="border p-3 text-left">Wali Kelas</th>
                                    <th class="border p-3 text-left">Jml Siswa</th>
                                    <th class="border p-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $index => $k)
                                <tr>
                                    <td class="border p-3">{{ $loop->iteration }}</td>
                                    <td class="border p-3">{{ $k->nama_kelas }}</td>
                                    <td class="border p-3">{{ $k->tingkat }}</td>
                                    <td class="border p-3">{{ $k->tahun_ajaran }}</td>
                                    <td class="border p-3">{{ $k->waliKelas->name ?? 'Belum ditentukan' }}</td>
                                    <td class="border p-3 text-center">{{ $k->siswa_count ?? 0 }}</td>
                                    <td class="border p-3">
                                        <form action="{{ route('admin.kelas.destroy', $k->id) }}" 
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Yakin hapus {{ $k->nama_kelas }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="border p-3 text-center">Tidak ada data kelas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $kelas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>