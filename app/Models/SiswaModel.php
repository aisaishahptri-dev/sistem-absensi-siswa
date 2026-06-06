<?php
// app/Models/SiswaModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id'; // Perbaiki: sesuai migration
    protected $fillable = [
        'user_id',
        'kelas_id',      // Perbaiki: sesuai migration pakai kelas_id
        'nis',
        'nama_lengkap',  // Perbaiki: sesuai migration
        'jenis_kelamin', // Perbaiki: sesuai migration
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id', 'id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiModel::class, 'siswa_id', 'id');
    }

    public function izin()
    {
        return $this->hasMany(IzinModel::class, 'siswa_id', 'id');
    }
}