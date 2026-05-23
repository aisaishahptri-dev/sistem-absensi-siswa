<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('izin')->insert([
            [
                'siswa_id' => 1,
                'tanggal_mulai' => '2024-06-02',
                'tanggal_selesai' => '2024-06-02',
                'alasan' => 'Sakit',
                'lampiran' => 'izin_sakit.pdf',
                'disetujui_oleh' => '2',
                'status' => 'Disetujui',
            ],
            [
                'siswa_id' => 2,
                'tanggal_mulai' => '2024-06-02',
                'tanggal_selesai' => '2024-06-02',
                'alasan' => 'Keluarga',
                'lampiran' => 'izin_keluarga.pdf',
                'disetujui_oleh' => '2',
                'status' => 'Pending',
            ],
            [
                'siswa_id' => 3,
                'tanggal_mulai' => '2024-06-02',
                'tanggal_selesai' => '2024-06-02',
                'alasan' => 'Lainnya',
                'lampiran' => 'izin_lainnya.pdf',
                'disetujui_oleh' => '2',
                'status' => 'Pending',
            ],
        ]);
    }
}
