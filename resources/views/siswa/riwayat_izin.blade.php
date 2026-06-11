<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy">📄 Riwayat Pengajuan Izin</h2>
            <a href="{{ route('siswa.izin.form') }}" class="bg-navy hover:bg-opacity-90 text-white px-4 py-2 rounded-xl font-semibold">+ Ajukan Izin</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-baby-blue">
                            <tr>
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">No</th>
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">Tanggal</th>
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">Alasan</th>
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($izin as $i)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($i->tanggal_mulai)->format('d/m/Y') }} @if($i->tanggal_mulai != $i->tanggal_selesai) → {{ \Carbon\Carbon::parse($i->tanggal_selesai)->format('d/m/Y') }} @endif</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ Str::limit($i->alasan, 40) }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    @if($i->status == 'pending')<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">⏳ Pending</span>
                                    @elseif($i->status == 'disetujui')<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">✅ Disetujui</span>
                                    @else<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">❌ Ditolak</span>@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t">{{ $izin->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>