<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">📊 Dashboard Siswa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-navy rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Halo, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-baby-blue">Kelas: <strong class="text-white">{{ $siswa->kelas->nama_kelas ?? '-' }}</strong></p>
                    </div>
                    <div class="text-6xl">👨‍🎓</div>
                </div>
            </div>

            @if($today)
                <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-xl mb-6 text-green-800">✅ Anda sudah absen hari ini dengan status: <strong>{{ strtoupper($today->status) }}</strong></div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-xl mb-6 text-yellow-800">
                    ⚠️ Anda belum absen hari ini 
                    <a href="{{ route('siswa.absen.form') }}" class="ml-4 bg-navy text-white px-4 py-2 rounded-xl font-semibold">📝 Absen Sekarang</a>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-green-500 text-white p-4 rounded-xl text-center"><p class="font-semibold">✅ Hadir</p><h2 class="text-3xl font-bold">{{ $hadir }}</h2></div>
                <div class="bg-yellow-500 text-white p-4 rounded-xl text-center"><p class="font-semibold">🤒 Sakit</p><h2 class="text-3xl font-bold">{{ $sakit }}</h2></div>
                <div class="bg-blue-500 text-white p-4 rounded-xl text-center"><p class="font-semibold">📝 Izin</p><h2 class="text-3xl font-bold">{{ $izin }}</h2></div>
                <div class="bg-gray-500 text-white p-4 rounded-xl text-center"><p class="font-semibold">❌ Alpa</p><h2 class="text-3xl font-bold">{{ $alpa }}</h2></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('siswa.absensi') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center font-semibold">📋 Lihat Rekap Absensi</a>
                <a href="{{ route('siswa.izin.form') }}" class="bg-baby-blue hover:bg-opacity-80 text-navy p-4 rounded-xl text-center font-semibold">📄 Ajukan Izin</a>
            </div>
        </div>
    </div>
</x-app-layout>