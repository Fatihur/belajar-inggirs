<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'materi_id',
        'durasi_menit',
        'nilai_minimal',
        'tingkat_kesulitan',
        'dibuat_oleh',
        'aktif',
        'acak_soal',
        'tampilkan_jawaban'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'acak_soal' => 'boolean',
        'tampilkan_jawaban' => 'boolean',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function soal()
    {
        return $this->hasMany(SoalKuis::class, 'kuis_id');
    }

    public function percobaan()
    {
        return $this->hasMany(PercobaanKuis::class, 'kuis_id');
    }
}
