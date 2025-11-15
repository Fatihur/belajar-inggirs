<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PercobaanKuis extends Model
{
    protected $table = 'percobaan_kuis';
    
    protected $fillable = [
        'kuis_id',
        'siswa_id',
        'waktu_mulai',
        'waktu_selesai',
        'nilai',
        'jumlah_benar',
        'jumlah_salah',
        'total_soal',
        'status',
        'lulus'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'lulus' => 'boolean'
    ];

    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanSiswa::class, 'percobaan_id');
    }
}
