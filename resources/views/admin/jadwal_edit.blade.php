<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">✏️ Edit Jadwal</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            @foreach($kelas as $k)<option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Guru</label>
                        <select name="guru_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            @foreach($guru as $g)<option value="{{ $g->id }}" {{ $jadwal->guru_id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" value="{{ $jadwal->mata_pelajaran }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Hari</label>
                        <select name="hari" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            <option {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block font-semibold text-gray-700">Jam Mulai</label><input type="time" name="jam_mulai" value="{{ $jadwal->jam_mulai }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700"></div>
                        <div><label class="block font-semibold text-gray-700">Jam Selesai</label><input type="time" name="jam_selesai" value="{{ $jadwal->jam_selesai }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700"></div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-navy hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold">Update</button>
                        <a href="{{ route('admin.jadwal') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>