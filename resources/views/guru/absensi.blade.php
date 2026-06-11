<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📝 Absensi Kelas {{ $kelas->nama_kelas }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-navy p-4 flex justify-between">
                    <h3 class="font-bold text-white">📋 Form Absensi</h3>
                    <span class="text-baby-blue">📅 {{ now()->format('d/m/Y') }}</span>
                </div>
                <div class="p-6">
                    <form action="{{ route('guru.absensi.submit') }}" method="POST">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-baby-blue">
                                    <tr>
                                        <th class="border border-gray-200 px-4 py-2 text-navy font-semibold">No</th>
                                        <th class="border border-gray-200 px-4 py-2 text-navy font-semibold">NIS</th>
                                        <th class="border border-gray-200 px-4 py-2 text-navy font-semibold">Nama</th>
                                        <th class="border border-gray-200 px-4 py-2 text-navy font-semibold">Status</th>
                                        <th class="border border-gray-200 px-4 py-2 text-navy font-semibold">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-2 text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="border border-gray-200 px-4 py-2 text-gray-700">{{ $s->nis }}</td>
                                        <td class="border border-gray-200 px-4 py-2 text-gray-800 font-medium">{{ $s->nama_lengkap }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            <select name="absensi[{{ $s->id }}]" class="border rounded px-2 py-1 text-gray-700" required>
                                                <option value="">Pilih</option>
                                                <option value="hadir">✅ Hadir</option>
                                                <option value="izin">📝 Izin</option>
                                                <option value="sakit">🤒 Sakit</option>
                                                <option value="alpa">❌ Alpa</option>
                                            </select>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            <input type="text" name="keterangan[{{ $s->id }}]" placeholder="Keterangan" class="border rounded px-2 py-1 w-32 text-gray-700">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="bg-navy hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold">💾 Simpan</button>
                            <a href="{{ route('guru.kelas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>