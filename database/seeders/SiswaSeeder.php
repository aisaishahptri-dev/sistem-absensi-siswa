<?php

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
                'nama_lengkap' => 'Ahmad Fauzi',
                'kelas_id' => 1,
                'user_id' => 3, // Assuming the siswa user has ID 3
                'nis' => '1234567890',
                'jenis_kelamin' => 'Laki-laki',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'kelas_id' => 2,
                'user_id' => 4, // Assuming the siswa user has ID 4
                'nis' => '0987654321',
                'jenis_kelamin' => 'Laki-laki',
            ],
            [
                'nama_lengkap' => 'Citra Lestari',
                'kelas_id' => 3,
                'user_id' => 5, // Assuming the siswa user has ID 5
                'nis' => '1122334455',
                'jenis_kelamin' => 'Perempuan',
            ],
        ]);
    }
}
