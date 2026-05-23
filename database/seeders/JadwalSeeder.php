<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal')->insert([
            [
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:00:00',
                'mata_pelajaran' => 'Matematika',
                'guru_id' => 2, // Assuming the guru user has ID 2
                'kelas_id' => 1, // Assuming the kelas has ID 1
            ],
            [
                'hari' => 'Selasa',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'mata_pelajaran' => 'Bahasa Indonesia',
                'guru_id' => 2, // Assuming the guru user has ID 2
                'kelas_id' => 1, // Assuming the kelas has ID 1
            ],
            [
                'hari' => 'Rabu',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '15:00:00',
                'mata_pelajaran' => 'Bahasa Inggris',
                'guru_id' => 2, // Assuming the guru user has ID 2
                'kelas_id' => 1, // Assuming the kelas has ID 1
            ],
        ]);
    }
}
