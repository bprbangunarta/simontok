<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Writeoff extends Model
{
    use HasFactory;

    protected $table = 'data_writeoff';
    protected $fillable = [
        'nocif',
        'nokredit',
        'nospk',
        'nama_debitur',
        'alamat',
        'wilayah',
        'plafon',
        'baki_debet',
        'kolektibilitas',
        'metode_rps',
        'jangka_waktu',
        'rate_bunga',
        'tgl_realisasi',
        'tgl_jatuh_tempo',
        'kode_petugas',
        'tunggakan_bunga',
        'tunggakan_denda',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'kode_petugas', 'kode');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'nokredit', 'nokredit');
    }
}
