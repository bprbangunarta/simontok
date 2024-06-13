<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_tugas';
    protected $fillable = [
        'notugas',
        'nokredit',
        'tanggal',
        'jenis',
        'pelaksanaan',
        'ket_pelaksanaan',
        'hasil',
        'ket_hasil',
        'catatan_leader',
        'foto_pelaksanaan',
        'tunggakan_pokok',
        'tunggakan_bunga',
        'tunggakan_denda',
        'status',
        'klasifikasi',
        'leader_id',
        'petugas_id',
    ];

    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'nokredit', 'nokredit');
    }

    public function writeoff()
    {
        return $this->belongsTo(Writeoff::class, 'nokredit', 'nokredit');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }

    public function verifikasi()
    {
        return $this->hasOne(Verifikasi::class, 'notugas', 'notugas');
    }

    public function janji()
    {
        return $this->hasOne(Janji::class, 'nokredit', 'nokredit');
    }
}
