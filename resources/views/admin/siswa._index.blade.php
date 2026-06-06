<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Siswa
            </h2>
            <a href="{{ route('admin.siswa.create') }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Siswa
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
                                    <th class="border p-3 text-left">NIS</th>
                                    <th class="border p-3 text-left">Nama Lengkap</th>
                                    <th class="border p-3 text-left">Kelas</th>
                                    <th class="border p-3 text-left">Jenis Kelamin</th>
                                    <th class="border p-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa as $index => $s)
                                <tr>
                                    <td class="border p-3">{{ $loop->iteration }}</td>
                                    <td class="border p-3">{{ $s->nis }}</td>
                                    <td class="border p-3">{{ $s->nama_lengkap }}</td>
                                    <td class="border p-3">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                    <td class="border p-3">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td class="border p-3">
                                        <a href="{{ route('admin.siswa.edit', $s->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                                        
                                        <form action="{{ route('admin.siswa.destroy', $s->id) }}" 
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Yakin hapus {{ $s->nama_lengkap }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="border p-3 text-center">Tidak ada data siswa</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $siswa->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>