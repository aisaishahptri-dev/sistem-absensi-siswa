<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Sapaan --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-gray-600">Kamu login sebagai <b>Siswa</b></p>
                @if($siswa && $siswa->kelas)
                    <p class="text-gray-500 mt-1">Kelas: <b class="text-purple-600">{{ $siswa->kelas->nama_kelas }}</b></p>
                @endif
            </div>

            {{-- Status Absen Hari Ini --}}
            @if($today)
                <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded mb-6">
                    <p class="text-green-700">✅ Anda sudah absen hari ini dengan status: <b>{{ strtoupper($today->status) }}</b></p>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded mb-6">
                    <p class="text-yellow-700">⚠️ Anda belum absen hari ini</p>
                    <a href="{{ route('siswa.absen.form') }}" class="inline-block mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        📝 Absen Sekarang
                    </a>
                </div>
            @endif

            {{-- Statistik Kehadiran --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">✅ Hadir</p>
                    <h2 class="text-3xl font-bold">{{ $hadir ?? 0 }}</h2>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">📝 Izin</p>
                    <h2 class="text-3xl font-bold">{{ $izin ?? 0 }}</h2>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">🤒 Sakit</p>
                    <h2 class="text-3xl font-bold">{{ $sakit ?? 0 }}</h2>
                </div>
                <div class="bg-gray-500 text-white p-4 rounded-lg shadow text-center">
                    <p class="text-sm">❌ Alpa</p>
                    <h2 class="text-3xl font-bold">{{ $alpa ?? 0 }}</h2>
                </div>
            </div>

            {{-- Menu Navigasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('siswa.absensi') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition">
                    📋 Lihat Rekap Absensi
                </a>
                <a href="{{ route('siswa.izin.form') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition">
                    📄 Ajukan Izin
                </a>
            </div>

            {{-- Informasi --}}
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 text-sm">💡 <b>Tips:</b> Absen setiap hari sebelum jam pelajaran dimulai. Jika sakit/izin, isi keterangan dengan jelas.</p>
            </div>

        </div>
    </div>
</x-app-layout>