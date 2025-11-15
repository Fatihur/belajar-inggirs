<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalKuis extends Model
{
    protected $table = 'soal_kuis';
    
    protected $fillable = [
        'kuis_id',
        'pertanyaan',
        'jenis_soal',
        'gambar_path',
        'audio_path',
        'poin',
        'urutan'
    ];

    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }

    public function pilihanJawaban()
    {
        return $this->hasMany(PilihanJawaban::class, 'soal_id');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'soal_id');
    }
}
