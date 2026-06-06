<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📄 Riwayat Pengajuan Izin
            </h2>
            <a href="{{ route('siswa.izin.form') }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                + Ajukan Izin Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4">
                    <h3 class="text-white font-bold text-lg">Riwayat Pengajuan Izin</h3>
                </div>

                <div class="p-6">
                    
                    @if($izin->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border p-3 text-center">No</th>
                                        <th class="border p-3 text-left">Tanggal Izin</th>
                                        <th class="border p-3 text-left">Alasan</th>
                                        <th class="border p-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($izin as $index => $i)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 text-center">{{ $izin->firstItem() + $index }}</td>
                                        <td class="border p-3">
                                            {{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d/m/Y') }}
                                            @if($i->tanggal_mulai != $i->tanggal_selesai)
                                                → {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td class="border p-3">
                                            {{ \Illuminate\Support\Str::limit($i->alasan, 50) }}
                                            @if($i->lampiran)
                                                <a href="{{ asset('storage/' . $i->lampiran) }}" target="_blank" class="text-blue-500 text-xs block">📎 Lihat lampiran</a>
                                            @endif
                                        </td>
                                        <td class="border p-3 text-center">
                                            @if($i->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-sm">⏳ Pending</span>
                                            @elseif($i->status == 'disetujui')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">✅ Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-sm">❌ Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $izin->links() }}
                        </div>

                    @else
                        <div class="text-center py-8">
                            <div class="text-5xl mb-4">📭</div>
                            <p class="text-gray-500">Belum ada pengajuan izin</p>
                            <a href="{{ route('siswa.izin.form') }}" class="text-blue-500 mt-2 inline-block">Ajukan izin sekarang →</a>
                        </div>
                    @endif

                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('siswa.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>