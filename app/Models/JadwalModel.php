<?php
// app/Models/JadwalModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id'; // Perbaiki: sesuai migration
    protected $fillable = [
        'kelas_id',        // Perbaiki: sesuai migration
        'guru_id',         // Perbaiki: sesuai migration
        'mata_pelajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiModel::class, 'jadwal_id', 'id');
    }
}