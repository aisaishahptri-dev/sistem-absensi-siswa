<?php
// app/Http/Controllers/SiswaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use App\Models\IzinModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa
     */
    public function dashboard()
    {
        $siswa = SiswaModel::with('kelas')->where('user_id', Auth::id())->first();
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Statistik kehadiran
        $hadir = AbsensiModel::where('siswa_id', $siswa->id)->where('status', 'hadir')->count();
        $izin = AbsensiModel::where('siswa_id', $siswa->id)->where('status', 'izin')->count();
        $sakit = AbsensiModel::where('siswa_id', $siswa->id)->where('status', 'sakit')->count();
        $alpa = AbsensiModel::where('siswa_id', $siswa->id)->where('status', 'alpa')->count();
        
        // Absensi hari ini
        $today = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();
        
        // Izin pending
        $izinPending = IzinModel::where('siswa_id', $siswa->id)
            ->where('status', 'pending')
            ->where('tanggal_mulai', '>=', today())
            ->count();
        
        return view('siswa.dashboard', compact(
            'siswa', 'hadir', 'izin', 'sakit', 'alpa', 'today', 'izinPending'
        ));
    }
    
    /**
     * Rekap Absensi Pribadi
     */
    public function absensi(Request $request)
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $absensi = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        
        return view('siswa.absensi', compact('siswa', 'absensi', 'bulan', 'tahun'));
    }
    
    /**
     * Form Absen Mandiri
     */
    public function formAbsen()
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        // Cek sudah absen hari ini
        $sudahAbsen = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();
        
        if ($sudahAbsen) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah absen hari ini');
        }
        
        return view('siswa.form_absen', compact('siswa'));
    }
    
    /**
     * Simpan Absen Mandiri
     */
    public function simpanAbsen(Request $request)
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
            'keterangan' => 'required_if:status,sakit,izin|nullable|string',
        ]);
        
        // Cek sudah absen
        $sudahAbsen = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();
        
        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan absen hari ini');
        }
        
        // Jika izin, buat pengajuan izin
        if ($request->status == 'izin') {
            IzinModel::create([
                'siswa_id' => $siswa->id,
                'tanggal_mulai' => today(),
                'tanggal_selesai' => today(),
                'alasan' => $request->keterangan,
                'status' => 'pending',
                'lampiran' => null,
            ]);
            
            return redirect()->route('siswa.dashboard')->with('success', 'Pengajuan izin telah dikirim, menunggu verifikasi wali kelas');
        }
        
        // Langsung catat absensi untuk hadir/sakit
        AbsensiModel::create([
            'siswa_id' => $siswa->id,
            'tanggal' => today(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'dicatat_oleh' => $siswa->user_id,
            'jadwal_id' => null,
        ]);
        
        return redirect()->route('siswa.dashboard')->with('success', 'Absen berhasil');
    }
    
    /**
     * Form Pengajuan Izin
     */
    public function formIzin()
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        return view('siswa.form_izin', compact('siswa'));
    }
    
    /**
     * Simpan Pengajuan Izin
     */
    public function simpanIzin(Request $request)
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|min:10',
        ]);
        
        IzinModel::create([
            'siswa_id' => $siswa->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending',
            'lampiran' => null,
            'disetujui_oleh' => null,
        ]);
        
        return redirect()->route('siswa.dashboard')->with('success', 'Pengajuan izin berhasil dikirim');
    }
    
    /**
     * Riwayat Izin
     */
    public function riwayatIzin()
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        $izin = IzinModel::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('siswa.riwayat_izin', compact('izin', 'siswa'));
    }
}