<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📊 Laporan Absensi</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div><label class="block font-semibold text-gray-700 mb-2">Bulan</label><select name="bulan" class="w-full border rounded-xl p-2 text-gray-700">@for($i=1;$i<=12;$i++)<option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>{{ Carbon\Carbon::create()->month($i)->format('F') }}</option>@endfor</select></div>
                    <div><label class="block font-semibold text-gray-700 mb-2">Tahun</label><select name="tahun" class="w-full border rounded-xl p-2 text-gray-700">@for($i=2020;$i<=date('Y');$i++)<option value="{{ $i }}" {{ $tahun==$i?'selected':'' }}>{{ $i }}</option>@endfor</select></div>
                    <div><label class="block font-semibold text-gray-700 mb-2">Kelas</label><select name="kelas_id" class="w-full border rounded-xl p-2 text-gray-700"><option value="">Semua Kelas</option>@foreach($kelas as $k)<option value="{{ $k->id }}" {{ $kelas_id==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>@endforeach</select></div>
                    <div class="flex items-end"><button type="submit" class="w-full bg-navy text-white py-2 rounded-xl hover:bg-opacity-90 font-semibold">🔍 Tampilkan</button></div>
                </form>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                    <div class="bg-baby-blue text-center p-3 rounded-xl"><p class="text-2xl font-bold text-navy">{{ number_format($statistik['total_siswa']) }}</p><p class="text-sm text-navy font-medium">Total Siswa</p></div>
                    <div class="bg-green-100 text-center p-3 rounded-xl"><p class="text-2xl font-bold text-green-700">{{ number_format($statistik['total_hadir']) }}</p><p class="text-sm text-green-700">✅ Hadir</p></div>
                    <div class="bg-yellow-100 text-center p-3 rounded-xl"><p class="text-2xl font-bold text-yellow-700">{{ number_format($statistik['total_sakit']) }}</p><p class="text-sm text-yellow-700">🤒 Sakit</p></div>
                    <div class="bg-blue-100 text-center p-3 rounded-xl"><p class="text-2xl font-bold text-blue-700">{{ number_format($statistik['total_izin']) }}</p><p class="text-sm text-blue-700">📝 Izin</p></div>
                    <div class="bg-gray-100 text-center p-3 rounded-xl"><p class="text-2xl font-bold text-gray-700">{{ number_format($statistik['total_alpa']) }}</p><p class="text-sm text-gray-700">❌ Alpa</p></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-baby-blue">
                            <tr>
                                <th class="border p-2 text-navy font-semibold">No</th>
                                <th class="border p-2 text-navy font-semibold">NIS</th>
                                <th class="border p-2 text-navy font-semibold">Nama</th>
                                <th class="border p-2 text-navy font-semibold">Kelas</th>
                                <th class="border p-2 text-center text-navy font-semibold">Hadir</th>
                                <th class="border p-2 text-center text-navy font-semibold">Sakit</th>
                                <th class="border p-2 text-center text-navy font-semibold">Izin</th>
                                <th class="border p-2 text-center text-navy font-semibold">Alpa</th>
                                <th class="border p-2 text-center text-navy font-semibold">Total</th>
                                <th class="border p-2 text-center text-navy font-semibold">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapSiswa as $rs)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border p-2 text-gray-700">{{ $rs['siswa']->nis }}</td>
                                <td class="border p-2 text-gray-800 font-medium">{{ $rs['siswa']->nama_lengkap }}</td>
                                <td class="border p-2 text-gray-700">{{ $rs['siswa']->kelas->nama_kelas ?? '-' }}</td>
                                <td class="border p-2 text-center text-green-600 font-semibold">{{ $rs['hadir'] }}</td>
                                <td class="border p-2 text-center text-yellow-600">{{ $rs['sakit'] }}</td>
                                <td class="border p-2 text-center text-blue-600">{{ $rs['izin'] }}</td>
                                <td class="border p-2 text-center text-gray-600">{{ $rs['alpa'] }}</td>
                                <td class="border p-2 text-center text-gray-700">{{ $rs['total'] }}</td>
                                <td class="border p-2 text-center text-gray-700">{{ $rs['total']>0?round(($rs['hadir']/$rs['total'])*100):0 }}%</td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="text-center p-4 text-gray-500">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>