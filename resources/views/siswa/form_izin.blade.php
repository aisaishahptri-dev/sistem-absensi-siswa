<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📄 Pengajuan Izin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4">
                    <h3 class="text-white font-bold text-lg">Form Pengajuan Izin</h3>
                    <p class="text-white/80 text-sm">Isi data dengan lengkap</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('siswa.izin.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Mulai *</label>
                            <input type="date" name="tanggal_mulai" required 
                                   class="w-full border rounded-lg p-2"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('tanggal_mulai') }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Selesai *</label>
                            <input type="date" name="tanggal_selesai" required 
                                   class="w-full border rounded-lg p-2"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('tanggal_selesai') }}">
                            <p class="text-gray-400 text-sm mt-1">Isi tanggal yang sama jika hanya 1 hari</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Alasan Izin *</label>
                            <textarea name="alasan" required rows="4" 
                                      class="w-full border rounded-lg p-2"
                                      placeholder="Jelaskan alasan izin secara detail...">{{ old('alasan') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Lampiran (Opsional)</label>
                            <input type="file" name="lampiran" 
                                   class="w-full border rounded-lg p-2"
                                   accept=".jpg,.jpeg,.png,.pdf">
                            <p class="text-gray-400 text-sm mt-1">Format: JPG, PNG, PDF (Max 2MB)</p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded">
                                ✨ Ajukan Izin
                            </button>
                            <a href="{{ route('siswa.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                                ← Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Perhatian:</b> Pengajuan izin akan diverifikasi oleh Wali Kelas. Izin yang disetujui akan otomatis tercatat dalam absensi.</p>
            </div>

        </div>
    </div>
</x-app-layout>