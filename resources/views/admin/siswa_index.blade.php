<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-2xl text-navy leading-tight">👨‍🎓 Manajemen Siswa</h2>
            <a href="{{ route('admin.siswa.create') }}" class="bg-navy hover:bg-opacity-90 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition-smooth transform hover:scale-105 flex items-center gap-2">
                <span>➕</span> Tambah Siswa
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="flash-message mb-6 bg-green-500 text-white p-4 rounded-xl shadow-lg">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500 text-white p-4 rounded-xl shadow-lg">⚠️ {{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-2xl shadow-md p-4 mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="searchInput" placeholder="🔍 Cari nama atau NIS..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue text-gray-700">
                    </div>
                    <div class="w-full sm:w-64">
                        <select id="kelasFilter" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue text-gray-700">
                            <option value="all">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-baby-blue">
                            <tr>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">No</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">NIS</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">Nama Lengkap</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">JK</th>
                                <th class="border border-gray-200 px-4 py-3 text-left text-sm font-semibold text-navy">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTableBody">
                            @forelse($siswa as $s)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $s->nis }}</td>
                                <td class="border border-gray-200 px-4 py-3 font-medium text-gray-800">{{ $s->nama_lengkap }}</td>
                                <td class="border border-gray-200 px-4 py-3"><span class="bg-baby-blue text-navy px-2 py-1 rounded-full text-xs font-semibold">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                                <td class="border border-gray-200 px-4 py-3 text-gray-700">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="border border-gray-200 px-4 py-3">
                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="text-navy hover:text-baby-blue mr-3 font-medium">✏️ Edit</a>
                                    <button onclick="confirmDelete({{ $s->id }}, '{{ $s->nama_lengkap }}')" class="text-red-500 hover:text-red-700 font-medium">🗑️ Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="border px-4 py-8 text-center text-gray-500">Belum ada data siswa</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-gray-200">{{ $siswa->links() }}</div>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="text-6xl mb-4">⚠️</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p id="deleteMessage" class="text-gray-600">Yakin ingin menghapus data ini?</p>
                <form id="deleteForm" method="POST" class="mt-6 flex justify-center gap-3">
                    @csrf @method('DELETE')
                    <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-200 rounded-xl text-gray-700">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-red-500 text-white rounded-xl">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, nama) {
            document.getElementById('deleteMessage').innerHTML = `Yakin hapus <strong class="text-navy">${nama}</strong>?`;
            document.getElementById('deleteForm').action = `/admin/siswa/${id}/destroy`;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        function closeModal() { document.getElementById('deleteModal').style.display = 'none'; }
        
        const searchInput = document.getElementById('searchInput');
        const kelasFilter = document.getElementById('kelasFilter');
        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const kelas = kelasFilter.value.toLowerCase();
            document.querySelectorAll('#siswaTableBody tr').forEach(row => {
                if (row.cells.length < 6) return;
                const nis = row.cells[1]?.innerText.toLowerCase() || '';
                const nama = row.cells[2]?.innerText.toLowerCase() || '';
                const kelasText = row.cells[3]?.innerText.toLowerCase() || '';
                const matchSearch = nis.includes(search) || nama.includes(search);
                const matchKelas = kelas === 'all' || kelasText.includes(kelas);
                row.style.display = matchSearch && matchKelas ? '' : 'none';
            });
        }
        searchInput.addEventListener('keyup', filterTable);
        kelasFilter.addEventListener('change', filterTable);
    </script>
</x-app-layout>