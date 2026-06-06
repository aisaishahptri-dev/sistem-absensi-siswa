<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Rekap Absensi
            </h2>
            <a href="{{ route('siswa.absen.form') }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                📝 Absen Hari Ini
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
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-bold text-lg">Riwayat Absensi</h3>
                        <div class="flex gap-2 text-sm">
                            <span class="bg-white/20 text-white px-2 py-1 rounded">✅ Hadir: {{ $absensi->where('status', 'hadir')->count() }}</span>
                            <span class="bg-white/20 text-white px-2 py-1 rounded">📝 Izin: {{ $absensi->where('status', 'izin')->count() }}</span>
                            <span class="bg-white/20 text-white px-2 py-1 rounded">🤒 Sakit: {{ $absensi->where('status', 'sakit')->count() }}</span>
                            <span class="bg-white/20 text-white px-2 py-1 rounded">❌ Alpa: {{ $absensi->where('status', 'alpa')->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    
                    @if($absensi->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border p-3 text-center">No</th>
                                        <th class="border p-3 text-left">Tanggal</th>
                                        <th class="border p-3 text-left">Status</th>
                                        <th class="border p-3 text-left">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensi as $index => $a)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 text-center">{{ $absensi->firstItem() + $index }}</td>
                                        <td class="border p-3">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                                        <td class="border p-3">
                                            @if($a->status == 'hadir')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">✅ Hadir</span>
                                            @elseif($a->status == 'izin')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-sm">📝 Izin</span>
                                            @elseif($a->status == 'sakit')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-sm">🤒 Sakit</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-sm">❌ Alpa</span>
                                            @endif
                                        </td>
                                        <td class="border p-3">{{ $a->keterangan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $absensi->links() }}
                        </div>

                    @else
                        <div class="text-center py-8">
                            <div class="text-5xl mb-4">📭</div>
                            <p class="text-gray-500">Belum ada data absensi</p>
                            <a href="{{ route('siswa.absen.form') }}" class="text-blue-500 mt-2 inline-block">Absen sekarang →</a>
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