<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosakata extends Model
{
    protected $table = 'kosakata';
    
    protected $fillable = [
        'materi_id',
        'kata_inggris',
        'kata_indonesia',
        'jenis_kata',
        'contoh_kalimat',
        'audio_path',
        'gambar_path',
        'urutan'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}
