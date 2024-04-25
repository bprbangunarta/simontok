<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Janji extends Model
{
    use HasFactory;

    protected $table = 'data_janji';
    protected $fillable = [
        'nokredit',
        'tanggal',
        'komitmen',
        'petugas_id',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
