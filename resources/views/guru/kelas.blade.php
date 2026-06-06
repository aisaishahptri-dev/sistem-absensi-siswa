<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏫 Kelas Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($kelas)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4">
                        <h3 class="text-white font-bold text-lg">📚 {{ $kelas->nama_kelas }}</h3>
                        <p class="text-white/80 text-sm">Tingkat {{ $kelas->tingkat }} | Tahun {{ $kelas->tahun_ajaran }}</p>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-gray-600">👨‍🎓 Jumlah Siswa: <b>{{ $kelas->siswa->count() }}</b> orang</p>
                            <p class="text-gray-600">📅 {{ now()->format('d/m/Y') }}</p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('guru.absensi') }}" 
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-3 rounded-lg transition">
                                📝 Absen Hari Ini
                            </a>
                            <a href="{{ route('guru.izin') }}" 
                               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 rounded-lg transition">
                                📋 Verifikasi Izin
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="text-5xl mb-4">🏫</div>
                    <h3 class="text-lg font-bold text-gray-700">Belum Ada Kelas</h3>
                    <p class="text-gray-500 mt-2">Anda belum ditugaskan sebagai wali kelas.</p>
                    <p class="text-gray-400 text-sm mt-1">Hubungi administrator untuk menambahkan kelas.</p>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('guru.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>