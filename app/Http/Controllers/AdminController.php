<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiswaModel;
use App\Models\GuruModel;
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
        $izinHariIni = IzinModel::whereDate('tanggal', today())->count();
        $persenKehadiran = $totalSiswa > 0 ? round(($absenHariIni / $totalSiswa) * 100) : 0;
        
        // Grafik Absensi 7 Hari Terakhir
        $grafikAbsensi = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $grafikAbsensi[] = [
                'tanggal' => $tanggal->format('d/m'),
                'hadir' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'hadir')->count(),
                'sakit' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'sakit')->count(),
                'izin' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'izin')->count(),
                'alpha' => AbsensiModel::whereDate('tanggal', $tanggal)->where('status', 'alpha')->count(),
            ];
        }
        
        // Kelas dengan absensi terbanyak
        $kelasTeraktif = KelasModel::withCount('siswa')->orderBy('siswa_count', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'totalJadwal',
            'absenHariIni', 'izinHariIni', 'persenKehadiran',
            'grafikAbsensi', 'kelasTeraktif'
        ));
    }
    
    /**
     * Manajemen Siswa (CRUD)
     */
    public function siswa()
    {
        $siswa = SiswaModel::with('kelas')->orderBy('nama', 'asc')->paginate(10);
        $kelas = KelasModel::all();
        return view('admin.siswa', compact('siswa', 'kelas'));
    }
    
    public function siswaTambah(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
        ]);
        
        // Buat akun user untuk siswa
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->nis . '@siswa.com',
            'password' => Hash::make($request->nis),
            'role' => 'siswa'
        ]);
        
        SiswaModel::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
        
        return back()->with('success', 'Siswa berhasil ditambahkan');
    }
    
    public function siswaEdit(Request $request, $id)
    {
        $siswa = SiswaModel::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis,' . $id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        
        $siswa->update($request->all());
        
        // Update user
        $siswa->user->update([
            'name' => $request->nama,
            'email' => $request->nis . '@siswa.com',
        ]);
        
        return back()->with('success', 'Siswa berhasil diupdate');
    }
    
    public function siswaHapus($id)
    {
        $siswa = SiswaModel::findOrFail($id);
        $siswa->user->delete(); // Hapus user juga
        $siswa->delete();
        
        return back()->with('success', 'Siswa berhasil dihapus');
    }
    
    /**
     * Manajemen Guru
     */
    public function guru()
    {
        $guru = User::where('role', 'guru')->orderBy('name', 'asc')->paginate(10);
        return view('admin.guru', compact('guru'));
    }
    
    public function guruTambah(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nuptk' => 'nullable|string|unique:guru,nuptk',
            'mata_pelajaran' => 'required|string',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru'
        ]);
        
        GuruModel::create([
            'user_id' => $user->id,
            'nuptk' => $request->nuptk,
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);
        
        return back()->with('success', 'Guru berhasil ditambahkan');
    }
    
    public function guruHapus($id)
    {
        $guru = User::findOrFail($id);
        
        // Cek apakah guru punya kelas wali
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->exists();
        if ($kelas) {
            return back()->with('error', 'Guru masih menjadi wali kelas, pindahkan terlebih dahulu');
        }
        
        $guru->delete();
        return back()->with('success', 'Guru berhasil dihapus');
    }
    
    /**
     * Manajemen Kelas
     */
    public function kelas()
    {
        $kelas = KelasModel::with('waliKelas', 'siswa')->orderBy('nama', 'asc')->paginate(10);
        $guru = User::where('role', 'guru')->get();
        return view('admin.kelas', compact('kelas', 'guru'));
    }
    
    public function kelasTambah(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama',
            'tingkat' => 'required|integer|min:1|max:12',
            'jurusan' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        
        KelasModel::create($request->all());
        
        return back()->with('success', 'Kelas berhasil ditambahkan');
    }
    
    public function kelasEdit(Request $request, $id)
    {
        $kelas = KelasModel::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:100|unique:kelas,nama,' . $id,
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);
        
        $kelas->update($request->all());
        
        return back()->with('success', 'Kelas berhasil diupdate');
    }
    
    public function kelasHapus($id)
    {
        $kelas = KelasModel::findOrFail($id);
        
        // Cek apakah ada siswa di kelas ini
        if ($kelas->siswa()->exists()) {
            return back()->with('error', 'Kelas masih memiliki siswa, pindahkan terlebih dahulu');
        }
        
        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus');
    }
    
    /**
     * Manajemen Jadwal
     */
    public function jadwal()
    {
        $jadwal = JadwalModel::with('kelas', 'guru')->orderBy('hari', 'asc')->orderBy('jam_mulai', 'asc')->paginate(15);
        $kelas = KelasModel::all();
        $guru = User::where('role', 'guru')->get();
        
        return view('admin.jadwal', compact('jadwal', 'kelas', 'guru'));
    }
    
    public function jadwalTambah(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran' => 'required|string',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
        
        JadwalModel::create($request->all());
        
        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }
    
    public function jadwalHapus($id)
    {
        JadwalModel::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus');
    }
    
    /**
     * Laporan Keseluruhan
     */
    public function laporan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $kelas_id = $request->kelas_id;
        
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
        foreach ($absensi->groupBy('siswa_id') as $siswa_id => $data) {
            $siswa = SiswaModel::find($siswa_id);
            $rekapSiswa[] = [
                'siswa' => $siswa,
                'hadir' => $data->where('status', 'hadir')->count(),
                'sakit' => $data->where('status', 'sakit')->count(),
                'izin' => $data->where('status', 'izin')->count(),
                'alpha' => $data->where('status', 'alpha')->count(),
            ];
        }
        
        $kelas = KelasModel::all();
        
        return view('admin.laporan', compact('absensi', 'rekapSiswa', 'kelas', 'bulan', 'tahun', 'kelas_id'));
    }
    
    /**
     * Export Laporan Excel/PDF
     */
    public function laporanExport(Request $request)
    {
        // Implementasi export ke Excel/PDF
        // Bisa menggunakan package maatwebsite/excel atau barryvdh/laravel-dompdf
    }
}