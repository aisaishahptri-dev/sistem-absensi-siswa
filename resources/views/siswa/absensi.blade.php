<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy">📋 Rekap Absensi</h2>
            <a href="{{ route('siswa.absen.form') }}" class="bg-navy hover:bg-opacity-90 text-white px-4 py-2 rounded-xl font-semibold">📝 Absen Hari Ini</a>
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
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">Status</th>
                                <th class="border border-gray-200 px-4 py-3 text-navy font-semibold">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi as $a)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    @if($a->status == 'hadir')<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">✅ Hadir</span>
                                    @elseif($a->status == 'izin')<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">📝 Izin</span>
                                    @elseif($a->status == 'sakit')<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">🤒 Sakit</span>
                                    @else<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold">❌ Alpa</span>@endif
                                </td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-600">{{ $a->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t">{{ $absensi->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>