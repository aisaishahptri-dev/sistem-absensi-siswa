<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $fillable = [
        'id_siswa',
        'tanggal',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaModel::class, 'id_siswa', 'id_siswa');
    }
}
