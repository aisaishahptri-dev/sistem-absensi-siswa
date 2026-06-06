<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Form Absen Hari Ini
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    {{ session('error') }}
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
                    <h3 class="text-white font-bold text-lg">Form Kehadiran</h3>
                    <p class="text-white/80 text-sm">{{ now()->format('d/m/Y') }}</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('siswa.absen.simpan') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Status Kehadiran *</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-green-50">
                                    <input type="radio" name="status" value="hadir" required class="w-4 h-4">
                                    <span>✅ Hadir (Masuk sekolah)</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-yellow-50">
                                    <input type="radio" name="status" value="izin" class="w-4 h-4">
                                    <span>📝 Izin (Tidak masuk karena keperluan)</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-red-50">
                                    <input type="radio" name="status" value="sakit" class="w-4 h-4">
                                    <span>🤒 Sakit (Tidak masuk karena sakit)</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4" id="keteranganGroup" style="display: none;">
                            <label class="block text-gray-700 font-bold mb-2">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="w-full border rounded-lg p-2" placeholder="Contoh: Saya sedang demam tinggi..."></textarea>
                            <p class="text-gray-400 text-sm mt-1">* Wajib diisi jika memilih Izin atau Sakit</p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded">
                                ✨ Submit Absen
                            </button>
                            <a href="{{ route('siswa.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                                ← Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Perhatian:</b> Anda hanya bisa absen satu kali sehari. Pastikan memilih status yang sesuai.</p>
            </div>

        </div>
    </div>

    <script>
        // Tampilkan input keterangan jika pilih izin atau sakit
        const radioButtons = document.querySelectorAll('input[name="status"]');
        const keteranganGroup = document.getElementById('keteranganGroup');
        
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'izin' || this.value === 'sakit') {
                    keteranganGroup.style.display = 'block';
                } else {
                    keteranganGroup.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>