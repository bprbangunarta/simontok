<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerifikasiAgunan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_verifikasi_agunan';
    protected $fillable = [
        'notugas',
        'noreg',
        'agunan',
        'kondisi',
        'penguasaan',
    ];

    public function agunan()
    {
        return $this->belongsTo(Agunan::class, 'noreg', 'noreg');
    }
}
