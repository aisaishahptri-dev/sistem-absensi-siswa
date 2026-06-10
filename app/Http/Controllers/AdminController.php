<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\AbsensiModel;
use App\Models\IzinModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Admin - Laporan Keseluruhan
     */
    public function dashboard()
    {
        // Statistik Utama
        $totalSiswa = SiswaModel::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalKelas = KelasModel::count();
        $totalJadwal = JadwalModel::count();
        
        // Statistik Absensi Hari Ini
        $absenHariIni = AbsensiModel::whereDate('tanggal', today())->count();
        
        // Izin yang sedang berlangsung hari ini (sudah disetujui)
        $izinHariIni = IzinModel::where('tanggal_mulai', '<=', today())
            ->where('tanggal_selesai', '>=', today())
            ->where('status', 'disetujui')
            ->count();
        
        $totalSiswaCount = $totalSiswa > 0 ? $totalSiswa : 1;
        $persenKehadiran = round(($absenHariIni / $totalSiswaCount) * 100);
        
        // Grafik Absensi 7 Hari Terakhir
        $grafikAbsensi = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $grafikAbsensi[] = [
                'tanggal' => $tanggal->format('d/m'),
                'hadir' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'hadir')->count(),
                'sakit' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'sakit')->count(),
                'izin' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'izin')->count(),
                'alpa' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'alpa')->count(),
            ];
        }
        
        // Kelas dengan siswa terbanyak
        $kelasTeraktif = KelasModel::withCount('siswa')->orderBy('siswa_count', 'desc')->take(5)->get();
        
        // User terbaru
        $userTerbaru = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'totalJadwal',
            'absenHariIni', 'izinHariIni', 'persenKehadiran',
            'grafikAbsensi', 'kelasTeraktif', 'userTerbaru'
        ));
    }
    
    // ==================== MANAJEMEN SISWA ====================
    
    public function siswa()
    {
        $siswa = SiswaModel::with('kelas')->orderBy('nama_lengkap', 'asc')->paginate(10);
        $kelas = KelasModel::all();
        return view('admin.siswa_index', compact('siswa', 'kelas'));
    }
    
    public function siswaCreate()
    {
        $kelas = KelasModel::all();
        return view('admin.siswa_create', compact('kelas'));
    }
    
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);
        
        // Buat akun user untuk siswa
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->nis . '@siswa.com',
            'password' => Hash::make($request->nis),
            'role' => 'siswa'
        ]);
        
        SiswaModel::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);
        
        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan');
    }
    
    public function siswaEdit($id)
    {
        $siswa = SiswaModel::findOrFail($id);
        $kelas = KelasModel::all();
        return view('admin.siswa_edit', compact('siswa', 'kelas'));
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        $siswa = SiswaModel::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);
        
        $siswa->update([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);
        
        // Update user
        if ($siswa->user) {
            $siswa->user->update([
                'name' => $request->nama_lengkap,
                'email' => $request->nis . '@siswa.com',
            ]);
        }
        
        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil diupdate');
    }
    
    public function siswaDestroy($id)
    {
        $siswa = SiswaModel::findOrFail($id);
        
        // Hapus user terkait
        if ($siswa->user) {
            $siswa->user->delete();
        }
        
        // Hapus data absensi dan izin
        AbsensiModel::where('siswa_id', $id)->delete();
        IzinModel::where('siswa_id', $id)->delete();
        
        $siswa->delete();
        
        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus');
    }
    
    // ==================== MANAJEMEN GURU ====================
    
    public function guru()
    {
        $guru = User::where('role', 'guru')
            ->orderBy('name', 'asc')
            ->paginate(10);
        
        return view('admin.guru_index', compact('guru'));
    }
    
    public function guruCreate()
    {
        return view('admin.guru_create');
    }
    
    public function guruStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru'
        ]);
        
        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan');
    }
    
    public function guruDestroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah guru punya kelas wali
        $kelas = KelasModel::where('wali_kelas_id', $user->id)->exists();
        if ($kelas) {
            return redirect()->route('admin.guru')->with('error', 'Guru masih menjadi wali kelas, pindahkan terlebih dahulu');
        }
        
        // Cek apakah guru mengajar di jadwal
        $jadwal = JadwalModel::where('guru_id', $user->id)->exists();
        if ($jadwal) {
            return redirect()->route('admin.guru')->with('error', 'Guru masih memiliki jadwal mengajar');
        }
        
        $user->delete();
        
        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus');
    }
    
    // ==================== MANAJEMEN KELAS ====================
    
    public function kelas()
    {
        $kelas = KelasModel::with('waliKelas', 'siswa')
            ->withCount('siswa')
            ->orderBy('tingkat', 'asc')
            ->orderBy('nama_kelas', 'asc')
            ->paginate(10);
        
        $guru = User::where('role', 'guru')->get();
        
        return view('admin.kelas_index', compact('kelas', 'guru'));
    }
    
    public function kelasCreate()
    {
        $guru = User::where('role', 'guru')->get();
        return view('admin.kelas_create', compact('guru'));
    }
    
    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:kelas,nama_kelas',
            'tingkat' => 'required|string|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        
        KelasModel::create($request->all());
        
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan');
    }
    
    public function kelasEdit($id)
    {
        $kelas = KelasModel::findOrFail($id);
        $guru = User::where('role', 'guru')->get();
        return view('admin.kelas_edit', compact('kelas', 'guru'));
    }
    
    public function kelasUpdate(Request $request, $id)
    {
        $kelas = KelasModel::findOrFail($id);
        
        $request->validate([
            'nama_kelas' => 'required|string|max:100|unique:kelas,nama_kelas,' . $id,
            'tingkat' => 'required|string|max:10',
            'tahun_ajaran' => 'required|string|max:20',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        
        $kelas->update($request->all());
        
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diupdate');
    }
    
    public function kelasDestroy($id)
    {
        $kelas = KelasModel::findOrFail($id);
        
        // Cek apakah ada siswa di kelas ini
        if ($kelas->siswa()->exists()) {
            return redirect()->route('admin.kelas')->with('error', 'Kelas masih memiliki siswa, pindahkan terlebih dahulu');
        }
        
        // Hapus jadwal terkait
        JadwalModel::where('kelas_id', $id)->delete();
        
        $kelas->delete();
        
        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus');
    }
    
    // ==================== MANAJEMEN JADWAL ====================
    
    public function jadwal()
    {
        $jadwal = JadwalModel::with('kelas', 'guru')
            ->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->paginate(15);
        
        $kelas = KelasModel::all();
        $guru = User::where('role', 'guru')->get();
        
        return view('admin.jadwal_index', compact('jadwal', 'kelas', 'guru'));
    }
    
    public function jadwalCreate()
    {
        $kelas = KelasModel::all();
        $guru = User::where('role', 'guru')->get();
        return view('admin.jadwal_create', compact('kelas', 'guru'));
    }
    
    public function jadwalStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string|max:100',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
        
        JadwalModel::create($request->all());
        
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil ditambahkan');
    }
    
    public function jadwalEdit($id)
    {
        $jadwal = JadwalModel::findOrFail($id);
        $kelas = KelasModel::all();
        $guru = User::where('role', 'guru')->get();
        return view('admin.jadwal_edit', compact('jadwal', 'kelas', 'guru'));
    }
    
    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = JadwalModel::findOrFail($id);
        
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string|max:100',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
        
        $jadwal->update($request->all());
        
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil diupdate');
    }
    
    public function jadwalDestroy($id)
    {
        JadwalModel::findOrFail($id)->delete();
        
        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil dihapus');
    }
    
    // ==================== LAPORAN ====================
    
    public function laporan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $kelas_id = $request->kelas_id;
        
        // Query absensi
        $query = AbsensiModel::with('siswa.kelas')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);
        
        if ($kelas_id) {
            $query->whereHas('siswa', function($q) use ($kelas_id) {
                $q->where('kelas_id', $kelas_id);
            });
        }
        
        $absensi = $query->get();
        
        // Rekap per siswa
        $rekapSiswa = [];
        $groupedAbsensi = $absensi->groupBy('siswa_id');
        
        foreach ($groupedAbsensi as $siswa_id => $data) {
            $siswa = SiswaModel::with('kelas')->find($siswa_id);
            if ($siswa) {
                $rekapSiswa[] = [
                    'siswa' => $siswa,
                    'hadir' => $data->where('status', 'hadir')->count(),
                    'sakit' => $data->where('status', 'sakit')->count(),
                    'izin' => $data->where('status', 'izin')->count(),
                    'alpa' => $data->where('status', 'alpa')->count(),
                    'total' => $data->count(),
                ];
            }
        }
        
        // Statistik keseluruhan
        $statistik = [
            'total_siswa' => $kelas_id ? SiswaModel::where('kelas_id', $kelas_id)->count() : SiswaModel::count(),
            'total_hadir' => $absensi->where('status', 'hadir')->count(),
            'total_sakit' => $absensi->where('status', 'sakit')->count(),
            'total_izin' => $absensi->where('status', 'izin')->count(),
            'total_alpa' => $absensi->where('status', 'alpa')->count(),
            'persen_kehadiran' => $absensi->count() > 0 ? round(($absensi->where('status', 'hadir')->count() / $absensi->count()) * 100) : 0,
        ];
        
        $kelas = KelasModel::all();
        
        return view('admin.laporan_absensi', compact(
            'absensi', 'rekapSiswa', 'kelas', 
            'bulan', 'tahun', 'kelas_id', 'statistik'
        ));
    }
    
    public function laporanKelas($id, Request $request)
    {
        $kelas = KelasModel::with('waliKelas')->findOrFail($id);
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $siswa = SiswaModel::where('kelas_id', $id)->get();
        
        $rekapAbsensi = [];
        foreach ($siswa as $s) {
            $absensi = AbsensiModel::where('siswa_id', $s->id)
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->get();
            
            $rekapAbsensi[] = [
                'siswa' => $s,
                'hadir' => $absensi->where('status', 'hadir')->count(),
                'sakit' => $absensi->where('status', 'sakit')->count(),
                'izin' => $absensi->where('status', 'izin')->count(),
                'alpa' => $absensi->where('status', 'alpa')->count(),
                'total' => $absensi->count(),
            ];
        }
        
        return view('admin.laporan_kelas', compact('kelas', 'rekapAbsensi', 'bulan', 'tahun'));
    }
}