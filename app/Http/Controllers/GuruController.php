<?php
// app/Http/Controllers/GuruController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use App\Models\IzinModel;
use App\Models\JadwalModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuruController extends Controller
{
    /**
     * Dashboard Guru
     */
    public function dashboard()
    {
        $guru = Auth::user();
        
        // Kelas yang diampu sebagai wali kelas
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return view('guru.dashboard', ['kelas' => null]);
        }
        
        // Statistik kelas
        $totalSiswa = SiswaModel::where('kelas_id', $kelas->id)->count();
        
        // Absensi hari ini
        $absenHariIni = AbsensiModel::whereHas('siswa', function($q) use ($kelas) {
            $q->where('kelas_id', $kelas->id);
        })->whereDate('tanggal', today())->count();
        
        // Persentase kehadiran hari ini
        $persenKehadiran = $totalSiswa > 0 ? round(($absenHariIni / $totalSiswa) * 100) : 0;
        
        // Izin pending
        $izinPending = IzinModel::whereHas('siswa', function($q) use ($kelas) {
            $q->where('kelas_id', $kelas->id);
        })->where('status', 'pending')->count();
        
        // Grafik kehadiran 7 hari terakhir
        $grafikKehadiran = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $grafikKehadiran[] = [
                'tanggal' => $tanggal->format('d/m'),
                'hadir' => AbsensiModel::whereHas('siswa', function($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->id);
                })->whereDate('tanggal', $tanggal)->count(),
            ];
        }
        
        return view('guru.dashboard', compact(
            'kelas', 'totalSiswa', 'absenHariIni', 
            'persenKehadiran', 'izinPending', 'grafikKehadiran'
        ));
    }
    
    /**
     * Kelas yang Diajar
     */
    public function kelasSaya()
    {
        $guru = Auth::user();
        $kelas = KelasModel::with('siswa')->where('wali_kelas_id', $guru->id)->first();
        
        return view('guru.kelas', compact('kelas'));
    }
    
    /**
     * Form Absensi (Input Absensi)
     */
    public function formAbsensi(Request $request)
    {
        $guru = Auth::user();
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        $tanggal = $request->tanggal ?? today();
        $siswa = SiswaModel::where('kelas_id', $kelas->id)->get();
        
        // Cek absensi yang sudah ada
        foreach ($siswa as $s) {
            $s->sudahAbsen = AbsensiModel::where('siswa_id', $s->id)
                ->whereDate('tanggal', $tanggal)
                ->first();
        }
        
        $jadwal = JadwalModel::where('kelas_id', $kelas->id)
            ->where('hari', $this->getHari($tanggal))
            ->first();
        
        return view('guru.absensi', compact('kelas', 'siswa', 'tanggal', 'jadwal'));
    }
    
    /**
     * Simpan Absensi
     */
    public function simpanAbsensi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'in:hadir,sakit,izin,alpha',
        ]);
        
        $guru = Auth::user();
        
        foreach ($request->absensi as $siswa_id => $status) {
            // Cek apakah sudah ada absensi hari ini
            $cek = AbsensiModel::where('siswa_id', $siswa_id)
                ->whereDate('tanggal', $request->tanggal)
                ->first();
            
            if ($cek) {
                $cek->update([
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null,
                    'dicatat_oleh' => $guru->id
                ]);
            } else {
                AbsensiModel::create([
                    'siswa_id' => $siswa_id,
                    'tanggal' => $request->tanggal,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null,
                    'jadwal_id' => $request->jadwal_id,
                    'dicatat_oleh' => $guru->id
                ]);
            }
        }
        
        return redirect()->route('guru.absensi')->with('success', 'Absensi berhasil disimpan');
    }
    
    /**
     * Verifikasi Izin Siswa
     */
    public function izin()
    {
        $guru = Auth::user();
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        $siswaIds = SiswaModel::where('kelas_id', $kelas->id)->pluck('id');
        
        $izin = IzinModel::with('siswa')
            ->whereIn('siswa_id', $siswaIds)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('guru.izin', compact('izin', 'kelas'));
    }
    
    /**
     * Verifikasi Izin (Approve/Reject)
     */
    public function verifikasiIzin($id, $status)
    {
        $izin = IzinModel::findOrFail($id);
        
        $validStatus = ['disetujui', 'ditolak'];
        if (!in_array($status, $validStatus)) {
            return back()->with('error', 'Status tidak valid');
        }
        
        $izin->update([
            'status' => $status,
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now()
        ]);
        
        // Jika disetujui, otomatis catat absensi
        if ($status == 'disetujui') {
            AbsensiModel::updateOrCreate(
                [
                    'siswa_id' => $izin->siswa_id,
                    'tanggal' => $izin->tanggal
                ],
                [
                    'status' => 'izin',
                    'keterangan' => $izin->keterangan,
                    'dicatat_oleh' => Auth::id()
                ]
            );
        }
        
        $message = $status == 'disetujui' ? 'Izin disetujui' : 'Izin ditolak';
        return back()->with('success', $message);
    }
    
    /**
     * Laporan Kelas yang Diampu
     */
    public function laporanKelas(Request $request)
    {
        $guru = Auth::user();
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $siswa = SiswaModel::where('kelas_id', $kelas->id)->get();
        
        // Rekap absensi per siswa
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
                'alpha' => $absensi->where('status', 'alpha')->count(),
                'total' => $absensi->count()
            ];
        }
        
        return view('guru.laporan', compact('kelas', 'rekapAbsensi', 'bulan', 'tahun'));
    }
    
    private function getHari($tanggal)
    {
        $hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
                 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 
                 'Saturday' => 'Sabtu'];
        return $hari[date('l', strtotime($tanggal))];
    }
}