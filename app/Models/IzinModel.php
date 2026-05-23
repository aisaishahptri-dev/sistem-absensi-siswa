<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinModel extends Model
{
    protected $table = 'izin';
    protected $primaryKey = 'id_izin';
    protected $fillable = [
        'id_siswa',
        'tanggal',
        'alasan',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }
}
