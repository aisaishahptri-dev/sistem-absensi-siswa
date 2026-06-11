<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📊 Dashboard Guru</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-navy rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Halo, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-baby-blue mt-1">Selamat datang di dashboard guru</p>
                        @if($kelas)<p class="text-baby-blue text-sm mt-2">Wali Kelas: <strong class="text-white">{{ $kelas->nama_kelas }}</strong></p>@endif
                    </div>
                    <div class="text-6xl">👨‍🏫</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue"><p class="text-gray-500">🏫 Kelas Diajar</p><p class="text-3xl font-bold text-navy">{{ $kelas ? 1 : 0 }}</p></div>
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue"><p class="text-gray-500">👨‍🎓 Total Siswa</p><p class="text-3xl font-bold text-navy">{{ $totalSiswa ?? 0 }}</p></div>
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue"><p class="text-gray-500">⏳ Izin Pending</p><p class="text-3xl font-bold text-navy">{{ $izinPending ?? 0 }}</p></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('guru.kelas') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition transform hover:scale-105 font-semibold">🏫 Kelas Saya</a>
                <a href="{{ route('guru.absensi') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition transform hover:scale-105 font-semibold">📝 Absensi Kelas</a>
                <a href="{{ route('guru.izin') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition transform hover:scale-105 font-semibold">📋 Verifikasi Izin</a>
            </div>
        </div>
    </div>
</x-app-layout>