<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kredit extends Model
{
    use HasFactory;

    protected $table = 'data_kredit';
    protected $fillable = [
        'nocif',
        'nokredit',
        'notabungan',
        'nospk',
        'produk_id',
        'nama_debitur',
        'alamat',
        'wilayah',
        'bidang',
        'resort',
        'nokaryawan',
        'plafon',
        'baki_debet',
        'kolektibilitas',
        'metode_rps',
        'jangka_waktu',
        'rate_bunga',
        'tgl_realisasi',
        'tgl_jatuh_tempo',
        'hari_tunggakan',
        'kode_petugas',
        'status',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function tunggakan()
    {
        return $this->hasOne(Tunggakan::class, 'nokredit', 'nokredit');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'kode_petugas', 'kode');
    }

    public function agunan()
    {
        return $this->hasMany(Agunan::class, 'nokredit', 'nokredit');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'nokredit', 'nokredit');
    }

    public function resign()
    {
        return $this->hasOne(Resign::class, 'nokaryawan', 'nokaryawan');
    }

    public function janji()
    {
        return $this->hasOne(Janji::class, 'nokredit', 'nokredit');
    }

    public function klasifikasi()
    {
        return $this->hasOne(Klasifikasi::class, 'nokredit', 'nokredit');
    }
}
