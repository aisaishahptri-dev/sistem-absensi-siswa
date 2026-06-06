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
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Statistik kehadiran bulan ini
        $bulanIni = Carbon::now();
        $absensiBulanIni = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', $bulanIni->year)
            ->whereMonth('tanggal', $bulanIni->month)
            ->get();
        
        $statistik = [
            'hadir' => $absensiBulanIni->where('status', 'hadir')->count(),
            'sakit' => $absensiBulanIni->where('status', 'sakit')->count(),
            'izin' => $absensiBulanIni->where('status', 'izin')->count(),
            'alpha' => $absensiBulanIni->where('status', 'alpha')->count(),
            'total' => $absensiBulanIni->count(),
        ];
        
        // Persentase kehadiran
        $hariSekolah = $this->getHariSekolahBulanIni();
        $persenKehadiran = $hariSekolah > 0 ? round(($statistik['hadir'] / $hariSekolah) * 100) : 0;
        
        // Absensi hari ini (apakah sudah absen?)
        $absenHariIni = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();
        
        // Izin pending
        $izinPending = IzinModel::where('siswa_id', $siswa->id)
            ->where('status', 'pending')
            ->count();
        
        // Grafik kehadiran 7 hari terakhir
        $grafikKehadiran = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $absen = AbsensiModel::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $tanggal)
                ->first();
            
            $grafikKehadiran[] = [
                'tanggal' => $tanggal->format('d/m'),
                'status' => $absen ? $absen->status : 'belum',
            ];
        }
        
        return view('siswa.dashboard', compact(
            'siswa', 'statistik', 'persenKehadiran', 
            'absenHariIni', 'izinPending', 'grafikKehadiran'
        ));
    }
    
    /**
     * Rekap Absensi Pribadi
     */
    public function rekapAbsensi(Request $request)
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
            ->orderBy('tanggal', 'asc')
            ->get();
        
        // Rekap per bulan
        $rekapBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $absensiBulan = AbsensiModel::where('siswa_id', $siswa->id)
                ->whereYear('tanggal', date('Y'))
                ->whereMonth('tanggal', $i)
                ->get();
            
            $rekapBulanan[$i] = [
                'bulan' => $this->getNamaBulan($i),
                'hadir' => $absensiBulan->where('status', 'hadir')->count(),
                'sakit' => $absensiBulan->where('status', 'sakit')->count(),
                'izin' => $absensiBulan->where('status', 'izin')->count(),
                'alpha' => $absensiBulan->where('status', 'alpha')->count(),
            ];
        }
        
        return view('siswa.rekap', compact('siswa', 'absensi', 'rekapBulanan', 'bulan', 'tahun'));
    }
    
    /**
     * Form Konfirmasi Kehadiran Mandiri
     */
    public function formKonfirmasi()
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        // Cek apakah sudah absen hari ini
        $sudahAbsen = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();
        
        if ($sudahAbsen) {
            return redirect()->route('siswa.dashboard')->with('info', 'Anda sudah melakukan konfirmasi kehadiran hari ini');
        }
        
        // Cek apakah ada izin pending
        $izinPending = IzinModel::where('siswa_id', $siswa->id)
            ->where('status', 'pending')
            ->whereDate('tanggal', today())
            ->exists();
        
        return view('siswa.konfirmasi', compact('siswa', 'izinPending'));
    }
    
    /**
     * Simpan Konfirmasi Kehadiran
     */
    public function simpanKonfirmasi(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
            'keterangan' => 'required_if:status,sakit,izin|nullable|string',
        ]);
        
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        // Cek sudah absen
        $sudahAbsen = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->exists();
        
        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan konfirmasi hari ini');
        }
        
        // Jika izin, buat pengajuan izin dulu
        if ($request->status == 'izin') {
            $izin = IzinModel::create([
                'siswa_id' => $siswa->id,
                'tanggal' => today(),
                'keterangan' => $request->keterangan,
                'status' => 'pending'
            ]);
            
            return redirect()->route('siswa.dashboard')->with('success', 'Pengajuan izin telah dikirim, menunggu verifikasi wali kelas');
        }
        
        // Langsung catat absensi untuk hadir/sakit
        AbsensiModel::create([
            'siswa_id' => $siswa->id,
            'tanggal' => today(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'dicatat_oleh' => $siswa->user_id // Dicatat oleh siswa sendiri
        ]);
        
        return redirect()->route('siswa.dashboard')->with('success', 'Konfirmasi kehadiran berhasil');
    }
    
    /**
     * Riwayat Izin Siswa
     */
    public function riwayatIzin()
    {
        $siswa = SiswaModel::where('user_id', Auth::id())->first();
        
        $izin = IzinModel::where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('siswa.riwayat_izin', compact('izin', 'siswa'));
    }
    
    /**
     * Helper Functions
     */
    private function getHariSekolahBulanIni()
    {
        // Hitung jumlah hari sekolah (Senin-Jumat) di bulan ini
        $bulan = Carbon::now();
        $hariSekolah = 0;
        $jumlahHari = $bulan->daysInMonth;
        
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggal = Carbon::create($bulan->year, $bulan->month, $i);
            $hari = $tanggal->dayOfWeek;
            // Senin=1, Selasa=2, Rabu=3, Kamis=4, Jumat=5
            if ($hari >= 1 && $hari <= 5) {
                $hariSekolah++;
            }
        }
        
        return $hariSekolah;
    }
    
    private function getNamaBulan($bulan)
    {
        $nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $nama[$bulan];
    }
}