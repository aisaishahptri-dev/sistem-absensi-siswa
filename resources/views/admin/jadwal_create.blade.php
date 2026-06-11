<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">➕ Tambah Jadwal</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Guru</label>
                        <select name="guru_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Hari</label>
                        <select name="hari" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            <option>Senin</option><option>Selasa</option><option>Rabu</option>
                            <option>Kamis</option><option>Jumat</option><option>Sabtu</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block font-semibold text-gray-700">Jam Mulai</label><input type="time" name="jam_mulai" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700"></div>
                        <div><label class="block font-semibold text-gray-700">Jam Selesai</label><input type="time" name="jam_selesai" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700"></div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-navy hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold">Simpan</button>
                        <a href="{{ route('admin.jadwal') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>