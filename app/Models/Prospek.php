<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospek extends Model
{
    use HasFactory;

    protected $table = 'data_prospek';
    protected $fillable = [
        'petugas_id',
        'tanggal',
        'jenis',
        'calon_debitur',
        'nohp',
        'keterangan',
        'foto_pelaksanaan',
        'status',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }
}
