<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-gray-600">Kamu login sebagai <b>Administrator</b></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                    <p class="text-sm">Total Siswa</p>
                    <h2 class="text-3xl font-bold">{{ $totalSiswa ?? 0 }}</h2>
                </div>

                <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                    <p class="text-sm">Total Guru</p>
                    <h2 class="text-3xl font-bold">{{ $totalGuru ?? 0 }}</h2>
                </div>

                <div class="bg-purple-500 text-white p-4 rounded-lg shadow">
                    <p class="text-sm">Total Kelas</p>
                    <h2 class="text-3xl font-bold">{{ $totalKelas ?? 0 }}</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <a href="{{ route('admin.siswa') }}" class="bg-blue-100 p-4 rounded-lg text-center hover:bg-blue-200">
                    📋 Manajemen Siswa
                </a>
                <a href="{{ route('admin.guru') }}" class="bg-green-100 p-4 rounded-lg text-center hover:bg-green-200">
                    👨‍🏫 Manajemen Guru
                </a>
                <a href="{{ route('admin.kelas') }}" class="bg-purple-100 p-4 rounded-lg text-center hover:bg-purple-200">
                    🏫 Manajemen Kelas
                </a>
            </div>
        </div>
    </div>
</x-app-layout>