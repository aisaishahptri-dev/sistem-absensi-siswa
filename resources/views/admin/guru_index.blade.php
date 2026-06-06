<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Guru
            </h2>
            <a href="{{ route('admin.guru.create') }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Guru
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
                                    <th class="border p-3 text-left">Nama</th>
                                    <th class="border p-3 text-left">Email</th>
                                    <th class="border p-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guru as $index => $g)
                                <tr>
                                    <td class="border p-3">{{ $loop->iteration }}</td>
                                    <td class="border p-3">{{ $g->name }}</td>
                                    <td class="border p-3">{{ $g->email }}</td>
                                    <td class="border p-3">
                                        <form action="{{ route('admin.guru.destroy', $g->id) }}" 
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Yakin hapus {{ $g->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="border p-3 text-center">Tidak ada data guru</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $guru->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>