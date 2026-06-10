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
            return view('guru.dashboard', compact('kelas'));
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
        
        return view('guru.dashboard', compact(
            'kelas', 'totalSiswa', 'absenHariIni', 
            'persenKehadiran', 'izinPending'
        ));
    }
    
    /**
     * Kelas yang Diajar
     */
    public function kelasSaya()
    {
        $guru = Auth::user();
        $kelas = KelasModel::with('siswa')->where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        return view('guru.kelas', compact('kelas'));
    }
    
    /**
     * Form Absensi
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
        
        // Cek jadwal untuk hari ini
        $hariIndo = $this->getHariIndonesia($tanggal);
        $jadwal = JadwalModel::where('kelas_id', $kelas->id)
            ->where('hari', $hariIndo)
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
            'absensi.*' => 'in:hadir,sakit,izin,alpa',
        ]);
        
        $guru = Auth::user();
        
        foreach ($request->absensi as $siswa_id => $status) {
            // Cek apakah sudah ada absensi hari ini
            $cek = AbsensiModel::where('siswa_id', $siswa_id)
                ->whereDate('tanggal', $request->tanggal)
                ->first();
            
            $keterangan = $request->keterangan[$siswa_id] ?? null;
            
            if ($cek) {
                $cek->update([
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'dicatat_oleh' => $guru->id
                ]);
            } else {
                AbsensiModel::create([
                    'siswa_id' => $siswa_id,
                    'tanggal' => $request->tanggal,
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'jadwal_id' => $request->jadwal_id,
                    'dicatat_oleh' => $guru->id
                ]);
            }
        }
        
        return redirect()->route('guru.kelas')->with('success', 'Absensi berhasil disimpan');
    }
    
    /**
     * Lihat Izin Siswa
     */
    public function izin(Request $request)
    {
        $guru = Auth::user();
        $kelas = KelasModel::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        $siswaIds = SiswaModel::where('kelas_id', $kelas->id)->pluck('id');
        
        $query = IzinModel::with('siswa')->whereIn('siswa_id', $siswaIds);
        
        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $izin = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('guru.izin', compact('izin', 'kelas'));
    }
    
    /**
     * Verifikasi Izin
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
        ]);
        
        // Jika disetujui, catat absensi untuk rentang tanggal
        if ($status == 'disetujui') {
            $startDate = Carbon::parse($izin->tanggal_mulai);
            $endDate = Carbon::parse($izin->tanggal_selesai);
            
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                AbsensiModel::updateOrCreate(
                    [
                        'siswa_id' => $izin->siswa_id,
                        'tanggal' => $date->format('Y-m-d')
                    ],
                    [
                        'status' => 'izin',
                        'keterangan' => $izin->alasan,
                        'dicatat_oleh' => Auth::id()
                    ]
                );
            }
        }
        
        $message = $status == 'disetujui' ? 'Izin disetujui' : 'Izin ditolak';
        return back()->with('success', $message);
    }
    
    /**
     * Helper: Konversi tanggal ke hari Indonesia
     */
    private function getHariIndonesia($tanggal)
    {
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $hari[date('l', strtotime($tanggal))];
    }
}       