<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📝 Form Absen Hari Ini</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('siswa.absen.simpan') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Status Kehadiran</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-green-50"><input type="radio" name="status" value="hadir" required> <span class="text-gray-700">✅ Hadir</span></label>
                            <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-yellow-50"><input type="radio" name="status" value="sakit"> <span class="text-gray-700">🤒 Sakit</span></label>
                            <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-blue-50"><input type="radio" name="status" value="izin"> <span class="text-gray-700">📝 Izin</span></label>
                        </div>
                    </div>
                    <div class="mb-4" id="keteranganGroup" style="display:none">
                        <label class="block font-semibold text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="w-full border rounded-xl p-3 text-gray-700" placeholder="Contoh: Sakit demam..."></textarea>
                        <p class="text-xs text-amber-600 mt-1">* Wajib diisi jika izin/sakit</p>
                    </div>
                    <button type="submit" class="w-full bg-navy hover:bg-opacity-90 text-white py-3 rounded-xl font-semibold">✨ Submit Absen</button>
                    <a href="{{ route('siswa.dashboard') }}" class="block text-center mt-3 text-gray-500 hover:text-navy">← Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="status"]').forEach(r=>{r.addEventListener('change',function(){document.getElementById('keteranganGroup').style.display=(this.value=='izin'||this.value=='sakit')?'block':'none';});});
    </script>
</x-app-layout>