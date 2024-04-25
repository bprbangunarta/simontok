<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'role',
        'password',
        'kode',
        'kode_kolektor',
        'kantor_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id', 'id');
    }

    public function prospek()
    {
        return $this->hasMany(Prospek::class, 'petugas_id', 'id');
    }

    public function leader()
    {
        return $this->hasMany(Tugas::class, 'leader_id', 'id');
    }

    public function petugas()
    {
        return $this->hasMany(Tugas::class, 'petugas_id', 'id');
    }

    public function kredit()
    {
        return $this->hasMany(Kredit::class, 'kode_petugas', 'kode');
    }

    public function janji()
    {
        return $this->hasMany(Janji::class, 'petugas_id', 'id');
    }

    public function writeoff()
    {
        return $this->hasMany(Tugas::class, 'kode_petugas', 'kode');
    }
}
