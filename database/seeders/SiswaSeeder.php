<?php
// database/seeders/SiswaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('siswa')->insert([
            [
                'user_id' => 3,      // Sesuai dengan user siswa1
                'kelas_id' => 1,     // X IPA 1
                'nis' => '1234567890',
                'nama_lengkap' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,      // Sesuai dengan user siswa2
                'kelas_id' => 2,     // X IPA 2
                'nis' => '0987654321',
                'nama_lengkap' => 'Citra Lestari',
                'jenis_kelamin' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,      // Sesuai dengan user siswa3
                'kelas_id' => 3,     // X IPS 1
                'nis' => '1122334455',
                'nama_lengkap' => 'Dewi Sartika',
                'jenis_kelamin' => 'P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}