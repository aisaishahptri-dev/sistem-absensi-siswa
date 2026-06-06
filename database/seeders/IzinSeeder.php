<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IzinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('izin')->insert([
            [
                'siswa_id' => 1,
                'tanggal_mulai' => '2024-06-10',
                'tanggal_selesai' => '2024-06-10',
                'alasan' => 'Sakit',
                'lampiran' => 'lampiran/sakit_ahmad.pdf',
                'disetujui_oleh' => 2,  // ✅ Diisi dengan ID guru
                'status' => 'disetujui',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'tanggal_mulai' => '2024-06-15',
                'tanggal_selesai' => '2024-06-17',
                'alasan' => 'Acara keluarga',
                'lampiran' => 'lampiran/keluarga_citra.pdf',
                'disetujui_oleh' => 2,  // ✅ Diisi dengan ID guru (default)
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 3,
                'tanggal_mulai' => '2024-06-20',
                'tanggal_selesai' => '2024-06-20',
                'alasan' => 'Ada keperluan mendesak',
                'lampiran' => null,
                'disetujui_oleh' => 2,  // ✅ Diisi dengan ID guru (default)
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}