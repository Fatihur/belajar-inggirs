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
        'nomor_induk',
        'kelas',
        'kelas_mengajar',
        'alamat',
        'no_telepon',
        'jenis_kelamin',
        'tanggal_lahir'
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
            'tanggal_lahir' => 'date'
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
}
