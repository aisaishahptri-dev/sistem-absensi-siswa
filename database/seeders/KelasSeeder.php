<?php

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
                'wali_kelas_id' => 2, // Assuming the guru user has ID 2
                'tahun_ajaran' => '2023/2024',
            ],
            [
                'nama_kelas' => 'X IPA 2',
                'tingkat' => 'X',
                'wali_kelas_id' => 2, // Assuming the guru user has ID 2
                'tahun_ajaran' => '2023/2024',
            ],
            [
                'nama_kelas' => 'X IPS 1',
                'tingkat' => 'X',
                'wali_kelas_id' => 2, // Assuming the guru user has ID 2
                'tahun_ajaran' => '2023/2024',
            ],
        ]);
    }
}
