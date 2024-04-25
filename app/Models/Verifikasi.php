<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verifikasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_verifikasi';
    protected $fillable = [
        'notugas',
        'pengguna_kredit',
        'penggunaan_kredit',
        'usaha_debitur',
        'cara_pembayaran',
        'alamat_rumah',
        'karakter_debitur',
        'nomor_debitur',
        'nomor_pendamping',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'notugas', 'notugas');
    }
}
