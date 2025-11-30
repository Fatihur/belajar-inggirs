<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'peran_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    public function materiDibuat()
    {
        return $this->hasMany(Materi::class, 'dibuat_oleh');
    }

    public function kuisDibuat()
    {
        return $this->hasMany(Kuis::class, 'dibuat_oleh');
    }

    public function percobaanKuis()
    {
        return $this->hasMany(PercobaanKuis::class, 'siswa_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    // Helper methods
    public function isSuperAdmin()
    {
        return $this->peran->nama_peran === 'super_admin';
    }

    public function isGuru()
    {
        return $this->peran->nama_peran === 'guru';
    }

    public function isSiswa()
    {
        return $this->peran->nama_peran === 'siswa';
    }

    // Accessor untuk mendapatkan kelas siswa
    public function getKelasAttribute()
    {
        return $this->siswa?->kelas;
    }

    // Accessor untuk mendapatkan kelas mengajar guru
    public function getKelasMengajarAttribute()
    {
        return $this->guru?->kelas_mengajar;
    }

    // Accessor untuk mendapatkan nomor induk (NIS/NIP)
    public function getNomorIndukAttribute()
    {
        if ($this->isSiswa()) {
            return $this->siswa?->nis;
        }
        if ($this->isGuru()) {
            return $this->guru?->nip;
        }
        return null;
    }
}
