<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('absensi')->insert([
            [
                'siswa_id' => 1,
                'tanggal' => '2024-06-01',
                'status' => 'Hadir',
                'jadwal_id' => 1, // Assuming the jadwal with ID 1 exists
                'dicatat_oleh' => 2, // Assuming the guru user has ID 2
                'keterangan' => 'Hadir tepat waktu',
            ],
            [
                'siswa_id' => 2,
                'tanggal' => '2024-06-01',
                'status' => 'Izin',
                'jadwal_id' => 1, // Assuming the jadwal with ID 1 exists
                'dicatat_oleh' => 2, // Assuming the guru user has ID 2
                'keterangan' => 'Izin menghadiri acara keluarga',
            ],
            [
                'siswa_id' => 3,
                'tanggal' => '2024-06-01',
                'status' => 'Sakit',
                'jadwal_id' => 1, // Assuming the jadwal with ID 1 exists
                'dicatat_oleh' => 2, // Assuming the guru user has ID 2
                'keterangan' => 'Sakit flu dan demam',
            ],
        ]);
    }
}
