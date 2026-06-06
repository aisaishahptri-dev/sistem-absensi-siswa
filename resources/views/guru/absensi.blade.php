<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Absensi Kelas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    Terjadi kesalahan. Silakan cek kembali data Anda.
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-bold text-lg">📋 Absensi Kelas {{ $kelas->nama_kelas }}</h3>
                        <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                            📅 {{ now()->format('d/m/Y') }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('guru.absensi.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border p-3 text-center">No</th>
                                        <th class="border p-3 text-left">NIS</th>
                                        <th class="border p-3 text-left">Nama Siswa</th>
                                        <th class="border p-3 text-left">Status</th>
                                        <th class="border p-3 text-left">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $index => $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border p-3 text-center">{{ $loop->iteration }}</td>
                                        <td class="border p-3">{{ $s->nis }}</td>
                                        <td class="border p-3">{{ $s->nama_lengkap }}</td>
                                        <td class="border p-3">
                                            <select name="absensi[{{ $s->id }}]" 
                                                    class="border rounded p-2 w-32" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="hadir">✅ Hadir</option>
                                                <option value="izin">📝 Izin</option>
                                                <option value="sakit">🤒 Sakit</option>
                                                <option value="alpa">❌ Alpa</option>
                                            </select>
                                        </td>
                                        <td class="border p-3">
                                            <input type="text" name="keterangan[{{ $s->id }}]" 
                                                   placeholder="Opsional"
                                                   class="border rounded p-2 w-40">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded">
                                💾 Simpan Absensi
                            </button>
                            <a href="{{ route('guru.kelas') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                                ← Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Petunjuk:</b> Pilih status kehadiran untuk setiap siswa. Keterangan diisi jika siswa izin atau sakit.</p>
            </div>

        </div>
    </div>
</x-app-layout>