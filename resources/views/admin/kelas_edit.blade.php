<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">✏️ Edit Kelas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Nama Kelas</label>
                        <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Tingkat</label>
                        <select name="tingkat" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            <option value="X" {{ $kelas->tingkat == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ $kelas->tingkat == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ $kelas->tingkat == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" value="{{ $kelas->tahun_ajaran }}" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Wali Kelas</label>
                        <select name="wali_kelas_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}" {{ $kelas->wali_kelas_id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-navy hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold">Update</button>
                        <a href="{{ route('admin.kelas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>