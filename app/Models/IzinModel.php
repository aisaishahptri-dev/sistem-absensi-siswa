<?php
// app/Models/IzinModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinModel extends Model
{
    protected $table = 'izin';
    protected $primaryKey = 'id'; // Perbaiki: sesuai migration
    protected $fillable = [
        'siswa_id',
        'disetujui_oleh',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status',
        'lampiran'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'siswa_id', 'id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh', 'id');
    }
}