<nav x-data="{ open: false }" class="bg-navy shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ 
                        auth()->user()->role == 'admin' ? route('admin.dashboard') : 
                        (auth()->user()->role == 'guru' ? route('guru.dashboard') : 
                        route('siswa.dashboard')) 
                    }}" class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="text-2xl">📚</span>
                        <span>Absensi Sekolah</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📊 Dashboard
                            </a>
                            <a href="{{ route('admin.siswa') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.siswa*') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                👨‍🎓 Siswa
                            </a>
                            <a href="{{ route('admin.guru') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.guru*') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                👨‍🏫 Guru
                            </a>
                            <a href="{{ route('admin.kelas') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.kelas*') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                🏫 Kelas
                            </a>
                            <a href="{{ route('admin.jadwal') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.jadwal*') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📅 Jadwal
                            </a>
                            <a href="{{ route('admin.laporan') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.laporan*') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📊 Laporan
                            </a>
                        @elseif(auth()->user()->role == 'guru')
                            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('guru.dashboard') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📊 Dashboard
                            </a>
                            <a href="{{ route('guru.kelas') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('guru.kelas') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                🏫 Kelas Saya
                            </a>
                            <a href="{{ route('guru.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('guru.absensi') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📝 Absensi
                            </a>
                            <a href="{{ route('guru.izin') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('guru.izin') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📋 Izin Siswa
                            </a>
                        @elseif(auth()->user()->role == 'siswa')
                            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('siswa.dashboard') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📊 Dashboard
                            </a>
                            <a href="{{ route('siswa.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('siswa.absensi') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📋 Rekap Absensi
                            </a>
                            <a href="{{ route('siswa.izin.form') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('siswa.izin.form') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📄 Ajukan Izin
                            </a>
                            <a href="{{ route('siswa.riwayat-izin') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('siswa.riwayat-izin') ? 'border-white text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-sm font-medium transition">
                                📜 Riwayat Izin
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 rounded-full px-4 py-2 transition text-white">
                        <div class="w-8 h-8 rounded-full bg-baby-blue flex items-center justify-center text-navy text-sm font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50" style="display: none;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-300 hover:text-white hover:bg-white/10">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" class="sm:hidden bg-navy border-t border-white/10" style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📊 Dashboard</a>
                    <a href="{{ route('admin.siswa') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">👨‍🎓 Siswa</a>
                    <a href="{{ route('admin.guru') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">👨‍🏫 Guru</a>
                    <a href="{{ route('admin.kelas') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">🏫 Kelas</a>
                    <a href="{{ route('admin.jadwal') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📅 Jadwal</a>
                @elseif(auth()->user()->role == 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📊 Dashboard</a>
                    <a href="{{ route('guru.kelas') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">🏫 Kelas Saya</a>
                    <a href="{{ route('guru.absensi') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📝 Absensi</a>
                    <a href="{{ route('guru.izin') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📋 Izin Siswa</a>
                @elseif(auth()->user()->role == 'siswa')
                    <a href="{{ route('siswa.dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📊 Dashboard</a>
                    <a href="{{ route('siswa.absensi') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📋 Rekap Absensi</a>
                    <a href="{{ route('siswa.izin.form') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📄 Ajukan Izin</a>
                    <a href="{{ route('siswa.riwayat-izin') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">📜 Riwayat Izin</a>
                @endif
            @endauth
        </div>
    </div>
</nav>