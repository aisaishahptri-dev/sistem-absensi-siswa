<?php
// app/Models/AbsensiModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'dicatat_oleh',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'siswa_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalModel::class, 'jadwal_id', 'id');
    }

    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh', 'id');
    }
}