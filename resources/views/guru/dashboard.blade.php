<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Sapaan --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-gray-600">Kamu login sebagai <b>Guru / Wali Kelas</b></p>
                @if($kelas)
                    <p class="text-gray-500 mt-2">Wali Kelas: <b class="text-purple-600">{{ $kelas->nama_kelas }}</b></p>
                @endif
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-purple-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">🏫 Kelas yang Diajar</p>
                    <h2 class="text-3xl font-bold">{{ $kelas ? 1 : 0 }}</h2>
                </div>

                <div class="bg-blue-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">👨‍🎓 Total Siswa</p>
                    <h2 class="text-3xl font-bold">{{ $totalSiswa ?? 0 }}</h2>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">⏳ Izin Pending</p>
                    <h2 class="text-3xl font-bold">{{ $izinPending ?? 0 }}</h2>
                </div>
            </div>

            {{-- Menu Navigasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('guru.kelas') }}" 
                   class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white p-4 rounded-lg text-center transition">
                    🏫 Lihat Kelas Saya
                </a>
                <a href="{{ route('guru.izin') }}" 
                   class="bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white p-4 rounded-lg text-center transition">
                    📋 Verifikasi Izin Siswa
                </a>
            </div>

            {{-- Informasi --}}
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Tips:</b> Klik "Lihat Kelas Saya" untuk melakukan absensi harian.</p>
            </div>

        </div>
    </div>
</x-app-layout>