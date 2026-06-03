<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-bold mb-2">Halo, {{ auth()->user()->name }} 👋</h3>
                <p class="text-gray-600">Kamu login sebagai <b>Guru</b></p>
            </div>

            <div class="mt-6 bg-indigo-500 text-white p-4 rounded">
                <p>Absensi Hari Ini</p>
                <h2 class="text-2xl font-bold">--</h2>
            </div>

        </div>
    </div>
</x-app-layout>