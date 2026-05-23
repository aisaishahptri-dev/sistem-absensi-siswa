<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'id_kelas',
        'id_guru',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'id_kelas', 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(GuruModel::class, 'id_guru', 'id_guru');
    }
}
