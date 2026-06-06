<?php
// database/seeders/AbsensiSeeder.php

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
                'siswa_id' => 1,        // Ahmad Fauzi (X IPA 1)
                'tanggal' => '2024-06-01',
                'status' => 'hadir',    // status harus: hadir, izin, sakit, alpa
                'keterangan' => 'Hadir tepat waktu',
                'jadwal_id' => 1,
                'dicatat_oleh' => 2,    // Guru
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,        // Citra Lestari (X IPA 2)
                'tanggal' => '2024-06-01',
                'status' => 'izin',
                'keterangan' => 'Izin menghadiri acara keluarga',
                'jadwal_id' => 4,
                'dicatat_oleh' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 3,        // Dewi Sartika (X IPS 1)
                'tanggal' => '2024-06-01',
                'status' => 'sakit',
                'keterangan' => 'Sakit flu dan demam',
                'jadwal_id' => 5,
                'dicatat_oleh' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambah absensi untuk tanggal lain
            [
                'siswa_id' => 1,
                'tanggal' => '2024-06-02',
                'status' => 'hadir',
                'keterangan' => 'Hadir',
                'jadwal_id' => 2,
                'dicatat_oleh' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'tanggal' => '2024-06-02',
                'status' => 'alpa',
                'keterangan' => 'Tidak hadir tanpa keterangan',
                'jadwal_id' => 4,
                'dicatat_oleh' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}