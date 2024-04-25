<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    use HasFactory;

    protected $table = 'data_agunan';
    protected $fillable = [
        'noreg',
        'nokredit',
        'agunan',
    ];

    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'nokredit', 'nokredit');
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiAgunan::class, 'noreg', 'noreg');
    }
}
