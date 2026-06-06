<?php
// database/seeders/JadwalSeeder.php

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
                'kelas_id' => 1,              // X IPA 1
                'guru_id' => 2,               // Guru ID 2
                'mata_pelajaran' => 'Matematika',
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '09:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'guru_id' => 2,
                'mata_pelajaran' => 'Bahasa Indonesia',
                'hari' => 'Selasa',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '09:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 1,
                'guru_id' => 2,
                'mata_pelajaran' => 'Bahasa Inggris',
                'hari' => 'Rabu',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '09:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 2,
                'guru_id' => 2,
                'mata_pelajaran' => 'Matematika',
                'hari' => 'Senin',
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '11:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_id' => 3,
                'guru_id' => 2,
                'mata_pelajaran' => 'Ekonomi',
                'hari' => 'Senin',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '14:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}