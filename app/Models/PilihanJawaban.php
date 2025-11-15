<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    protected $table = 'pilihan_jawaban';
    
    protected $fillable = [
        'soal_id',
        'teks_jawaban',
        'jawaban_benar',
        'urutan'
    ];

    protected $casts = [
        'jawaban_benar' => 'boolean'
    ];

    public function soal()
    {
        return $this->belongsTo(SoalKuis::class, 'soal_id');
    }
}
