<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-navy leading-tight">📊 Dashboard Administrator</h2>
            <span class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Welcome Card --}}
            <div class="bg-navy rounded-2xl shadow-lg p-6 mb-8 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Halo, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-baby-blue mt-1">Selamat datang di dashboard administrator</p>
                    </div>
                    <div class="text-6xl">🎓</div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue card-hover transition-smooth">
                    <p class="text-gray-500 text-sm">Total Siswa</p>
                    <p class="text-3xl font-bold text-navy">{{ number_format($totalSiswa) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue card-hover transition-smooth">
                    <p class="text-gray-500 text-sm">Total Guru</p>
                    <p class="text-3xl font-bold text-navy">{{ number_format($totalGuru) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue card-hover transition-smooth">
                    <p class="text-gray-500 text-sm">Total Kelas</p>
                    <p class="text-3xl font-bold text-navy">{{ number_format($totalKelas) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-baby-blue card-hover transition-smooth">
                    <p class="text-gray-500 text-sm">Kehadiran Hari Ini</p>
                    <p class="text-3xl font-bold text-navy">{{ $persenKehadiran }}%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2"><div class="bg-baby-blue h-2 rounded-full" style="width: {{ $persenKehadiran }}%"></div></div>
                </div>
            </div>

            {{-- Quick Menu --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.siswa') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition-smooth transform hover:scale-105 shadow-md font-semibold">👨‍🎓 Kelola Siswa</a>
                <a href="{{ route('admin.guru') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition-smooth transform hover:scale-105 shadow-md font-semibold">👨‍🏫 Kelola Guru</a>
                <a href="{{ route('admin.kelas') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition-smooth transform hover:scale-105 shadow-md font-semibold">🏫 Kelola Kelas</a>
                <a href="{{ route('admin.jadwal') }}" class="bg-navy hover:bg-opacity-90 text-white p-4 rounded-xl text-center transition-smooth transform hover:scale-105 shadow-md font-semibold">📅 Kelola Jadwal</a>
            </div>
        </div>
    </div>
</x-app-layout>