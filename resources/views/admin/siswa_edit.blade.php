<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy leading-tight">✏️ Edit Siswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <h3 class="text-white font-bold text-lg">📝 Form Edit Siswa</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">NIS</label>
                            <input type="text" name="nis" required value="{{ $siswa->nis }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required value="{{ $siswa->nama_lengkap }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Kelas</label>
                            <select name="kelas_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                            <div class="flex gap-4">
                                <label class="text-gray-700"><input type="radio" name="jenis_kelamin" value="L" {{ $siswa->jenis_kelamin == 'L' ? 'checked' : '' }}> Laki-laki</label>
                                <label class="text-gray-700"><input type="radio" name="jenis_kelamin" value="P" {{ $siswa->jenis_kelamin == 'P' ? 'checked' : '' }}> Perempuan</label>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="flex-1 bg-navy hover:bg-opacity-90 text-white font-semibold py-3 rounded-xl">💾 Update</button>
                            <a href="{{ route('admin.siswa') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center py-3 rounded-xl font-medium">← Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>