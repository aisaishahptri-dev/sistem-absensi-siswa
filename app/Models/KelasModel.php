<?php
// app/Models/KelasModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id'; // Perbaiki: jadi 'id' sesuai migration
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'wali_kelas_id',
        'tahun_ajaran'
    ];

    public function siswa()
    {
        return $this->hasMany(SiswaModel::class, 'kelas_id', 'id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id', 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalModel::class, 'kelas_id', 'id');
    }
}