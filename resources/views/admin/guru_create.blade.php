<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-navy">➕ Tambah Guru</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <form action="{{ route('admin.guru.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Nama</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-navy hover:bg-opacity-90 text-white px-6 py-3 rounded-xl font-semibold">Simpan</button>
                        <a href="{{ route('admin.guru') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>