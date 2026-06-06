<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Verifikasi Izin Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-bold text-lg">📋 Daftar Izin Siswa</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('guru.izin') }}" class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">Semua</a>
                            <a href="{{ route('guru.izin', ['status' => 'pending']) }}" class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">Pending</a>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    
                    @if($izin->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border p-3 text-center">No</th>
                                        <th class="border p-3 text-left">NIS</th>
                                        <th class="border p-3 text-left">Nama Siswa</th>
                                        <th class="border p-3 text-left">Tanggal Izin</th>
                                        <th class="border p-3 text-left">Alasan</th>
                                        <th class="border p-3 text-center">Status</th>
                                        <th class="border p-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($izin as $index => $i)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 text-center">{{ $izin->firstItem() + $index }}</td>
                                        <td class="border p-3">{{ $i->siswa->nis }}</td>
                                        <td class="border p-3">{{ $i->siswa->nama_lengkap }}</td>
                                        <td class="border p-3">
                                            {{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d/m/Y') }}
                                            @if($i->tanggal_mulai != $i->tanggal_selesai)
                                                → {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td class="border p-3 max-w-xs">
                                            {{ \Illuminate\Support\Str::limit($i->alasan, 40) }}
                                            @if($i->lampiran)
                                                <a href="{{ asset('storage/' . $i->lampiran) }}" target="_blank" class="text-blue-500 text-xs block">📎 Lampiran</a>
                                            @endif
                                        </td>
                                        <td class="border p-3 text-center">
                                            @if($i->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">⏳ Pending</span>
                                            @elseif($i->status == 'disetujui')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">✅ Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">❌ Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="border p-3 text-center">
                                            @if($i->status == 'pending')
                                                <div class="flex gap-2 justify-center">
                                                    <form action="{{ route('guru.izin.verifikasi', ['id' => $i->id, 'status' => 'disetujui']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            ✅ Setujui
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('guru.izin.verifikasi', ['id' => $i->id, 'status' => 'ditolak']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                            ❌ Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $izin->withQueryString()->links() }}
                        </div>

                    @else
                        <div class="text-center py-8">
                            <div class="text-5xl mb-4">📭</div>
                            <p class="text-gray-500">Belum ada pengajuan izin</p>
                            <p class="text-gray-400 text-sm mt-1">Belum ada siswa yang mengajukan izin.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('guru.kelas') }}" class="text-gray-500 hover:text-gray-700">
                    ← Kembali ke Kelas
                </a>
            </div>

            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Petunjuk:</b> Klik "Setujui" untuk menyetujui izin siswa, atau "Tolak" untuk menolak izin.</p>
            </div>

        </div>
    </div>
</x-app-layout>