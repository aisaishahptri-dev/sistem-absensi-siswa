<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-bold mb-2">Halo, {{ auth()->user()->name }} 👋</h3>
                <p class="text-gray-600">Kamu login sebagai <b>Admin</b></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-blue-500 text-white p-4 rounded">
                    <p>Total Siswa</p>
                    <h2 class="text-2xl font-bold">--</h2>
                </div>

                <div class="bg-green-500 text-white p-4 rounded">
                    <p>Total Guru</p>
                    <h2 class="text-2xl font-bold">--</h2>
                </div>

                <div class="bg-yellow-500 text-white p-4 rounded">
                    <p>Total Kelas</p>
                    <h2 class="text-2xl font-bold">--</h2>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>