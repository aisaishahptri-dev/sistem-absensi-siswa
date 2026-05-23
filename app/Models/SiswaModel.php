<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'alamat',
        'no_telepon',
        'email',
    ];

    public function pembayaran()
    {
        return $this->hasMany(PembayaranModel::class, 'id_siswa', 'id_siswa');
    }
}
