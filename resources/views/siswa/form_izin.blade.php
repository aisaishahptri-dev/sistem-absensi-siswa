<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📄 Pengajuan Izin</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('siswa.izin.simpan') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required class="w-full border rounded-xl px-4 py-3 text-gray-700" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required class="w-full border rounded-xl px-4 py-3 text-gray-700" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Alasan</label>
                        <textarea name="alasan" required rows="4" class="w-full border rounded-xl p-3 text-gray-700" placeholder="Jelaskan alasan izin..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-navy hover:bg-opacity-90 text-white py-3 rounded-xl font-semibold">✨ Ajukan Izin</button>
                    <a href="{{ route('siswa.dashboard') }}" class="block text-center mt-3 text-gray-500 hover:text-navy">← Kembali</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>