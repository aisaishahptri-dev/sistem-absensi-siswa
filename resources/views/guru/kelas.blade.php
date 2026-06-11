<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">🏫 Kelas Saya</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            @if($kelas)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-navy p-6">
                    <h3 class="text-xl font-bold text-white">📚 {{ $kelas->nama_kelas }}</h3>
                    <p class="text-baby-blue mt-1">Tingkat {{ $kelas->tingkat }} | Tahun {{ $kelas->tahun_ajaran }}</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">👨‍🎓 Jumlah Siswa: <strong class="text-navy">{{ $kelas->siswa->count() }}</strong> orang</p>
                    <div class="flex gap-3">
                        <a href="{{ route('guru.absensi') }}" class="flex-1 bg-navy text-white text-center py-3 rounded-xl hover:bg-opacity-90 font-semibold">📝 Absen Hari Ini</a>
                        <a href="{{ route('guru.izin') }}" class="flex-1 bg-baby-blue text-navy text-center py-3 rounded-xl hover:bg-opacity-80 font-semibold">📋 Verifikasi Izin</a>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🏫</div>
                <h3 class="text-xl font-bold text-navy">Belum Ada Kelas</h3>
                <p class="text-gray-500 mt-2">Anda belum ditugaskan sebagai wali kelas.</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>