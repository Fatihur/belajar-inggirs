<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    
    protected $fillable = [
        'judul',
        'jenis_materi',
        'deskripsi',
        'konten',
        'video_url',
        'video_path',
        'dibuat_oleh',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function kosakata()
    {
        return $this->hasMany(Kosakata::class, 'materi_id');
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'materi_id');
    }
}
