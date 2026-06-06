<?php
// database/seeders/KelasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'X IPA 1',
                'tingkat' => 'X',
                'wali_kelas_id' => 2, // Guru ID 2
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kelas' => 'X IPA 2',
                'tingkat' => 'X',
                'wali_kelas_id' => 2,
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kelas' => 'X IPS 1',
                'tingkat' => 'X',
                'wali_kelas_id' => 2,
                'tahun_ajaran' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}