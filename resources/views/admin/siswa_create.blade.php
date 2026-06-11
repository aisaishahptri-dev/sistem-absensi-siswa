<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy leading-tight">➕ Tambah Siswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <h3 class="text-white font-bold text-lg">📝 Form Tambah Siswa</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.siswa.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                            <input type="text" name="nis" required value="{{ old('nis') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-baby-blue text-gray-700">
                            @error('nis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-baby-blue text-gray-700">
                            @error('nama_lengkap') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                            <select name="kelas_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-gray-700"><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                                <label class="flex items-center gap-2 text-gray-700"><input type="radio" name="jenis_kelamin" value="P" required> Perempuan</label>
                            </div>
                            @error('jenis_kelamin') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="flex-1 bg-navy hover:bg-opacity-90 text-white font-semibold py-3 rounded-xl">💾 Simpan</button>
                            <a href="{{ route('admin.siswa') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center py-3 rounded-xl font-medium">← Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>