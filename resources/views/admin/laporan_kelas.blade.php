<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Laporan Absensi Kelas {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    
                    {{-- Filter Bulan --}}
                    <form method="GET" class="flex gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Bulan</label>
                            <select name="bulan" class="border rounded-lg p-2">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Tahun</label>
                            <select name="tahun" class="border rounded-lg p-2">
                                @for($i=2020; $i<=date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded">🔍 Filter</button>
                        </div>
                    </form>

                    {{-- Informasi Kelas --}}
                    <div class="bg-gray-100 p-4 rounded mb-6">
                        <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
                        <p><strong>Wali Kelas:</strong> {{ $kelas->waliKelas->name ?? '-' }}</p>
                        <p><strong>Tahun Ajaran:</strong> {{ $kelas->tahun_ajaran }}</p>
                        <p><strong>Periode:</strong> {{ \Carbon\Carbon::create()->month($bulan)->format('F') }} {{ $tahun }}</p>
                    </div>

                    {{-- Tabel Rekap --}}
                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">No</th>
                                    <th class="border p-2">NIS</th>
                                    <th class="border p-2">Nama</th>
                                    <th class="border p-2 text-center">Hadir</th>
                                    <th class="border p-2 text-center">Sakit</th>
                                    <th class="border p-2 text-center">Izin</th>
                                    <th class="border p-2 text-center">Alpa</th>
                                    <th class="border p-2 text-center">Total</th>
                                    <th class="border p-2 text-center">% Hadir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapAbsensi as $rs)
                                <tr>
                                    <td class="border p-2">{{ $loop->iteration }}</td>
                                    <td class="border p-2">{{ $rs['siswa']->nis }}</td>
                                    <td class="border p-2">{{ $rs['siswa']->nama_lengkap }}</td>
                                    <td class="border p-2 text-center text-green-600">{{ $rs['hadir'] }}</td>
                                    <td class="border p-2 text-center text-yellow-600">{{ $rs['sakit'] }}</td>
                                    <td class="border p-2 text-center text-blue-600">{{ $rs['izin'] }}</td>
                                    <td class="border p-2 text-center text-gray-600">{{ $rs['alpa'] }}</td>
                                    <td class="border p-2 text-center">{{ $rs['total'] }}</td>
                                    <td class="border p-2 text-center">
                                        {{ $rs['total'] > 0 ? round(($rs['hadir'] / $rs['total']) * 100) : 0 }}%
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="border p-4 text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.laporan') }}" class="text-gray-500 hover:text-gray-700">
                            ← Kembali ke Laporan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>