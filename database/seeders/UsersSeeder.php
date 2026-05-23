<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Guru',
                'email' => 'guru@example.com',
                'password' => bcrypt('guru123'),
                'role' => 'guru',
            ],
            [
                'name' => 'Siswa 1',
                'email' => 'siswa1@example.com',
                'password' => bcrypt('siswa123'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Siswa 2',
                'email' => 'siswa2@example.com',
                'password' => bcrypt('siswa1234'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Siswa 3',
                'email' => 'siswa3@example.com',
                'password' => bcrypt('siswa12345'),
                'role' => 'siswa',
            ],
        ]);
    }
}
