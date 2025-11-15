<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswa';
    
    protected $fillable = [
        'percobaan_id',
        'soal_id',
        'pilihan_jawaban_id',
        'jawaban_isian',
        'benar',
        'poin_didapat'
    ];

    protected $casts = [
        'benar' => 'boolean'
    ];

    public function percobaan()
    {
        return $this->belongsTo(PercobaanKuis::class, 'percobaan_id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalKuis::class, 'soal_id');
    }

    public function pilihanJawaban()
    {
        return $this->belongsTo(PilihanJawaban::class, 'pilihan_jawaban_id');
    }
}
