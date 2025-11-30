<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'kelas_mengajar',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'pendidikan_terakhir',
        'bidang_studi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materiDibuat()
    {
        return $this->hasMany(Materi::class, 'dibuat_oleh', 'user_id');
    }

    public function kuisDibuat()
    {
        return $this->hasMany(Kuis::class, 'dibuat_oleh', 'user_id');
    }
}
