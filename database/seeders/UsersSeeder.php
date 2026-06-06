<?php
// database/seeders/UsersSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'guru@example.com',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'siswa1@example.com',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'siswa2@example.com',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Sartika',
                'email' => 'siswa3@example.com',
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}