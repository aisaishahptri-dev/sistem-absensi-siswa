<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kelas
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    
                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Kelas *</label>
                            <input type="text" name="nama_kelas" required
                                   class="w-full border rounded-lg p-2"
                                   value="{{ old('nama_kelas') }}">
                            @error('nama_kelas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-400 text-sm mt-1">Contoh: X IPA 1, XI IPS 2, XII MIPA 3</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tingkat *</label>
                            <select name="tingkat" required class="w-full border rounded-lg p-2">
                                <option value="">Pilih Tingkat</option>
                                <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X (10)</option>
                                <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI (11)</option>
                                <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII (12)</option>
                            </select>
                            @error('tingkat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tahun Ajaran *</label>
                            <input type="text" name="tahun_ajaran" required
                                   class="w-full border rounded-lg p-2"
                                   placeholder="2024/2025"
                                   value="{{ old('tahun_ajaran') }}">
                            @error('tahun_ajaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Wali Kelas (Opsional)</label>
                            <select name="wali_kelas_id" class="w-full border rounded-lg p-2">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_kelas_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                💾 Simpan
                            </button>
                            <a href="{{ route('admin.kelas') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                ← Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>