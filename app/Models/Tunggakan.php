<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunggakan extends Model
{
    use HasFactory;

    protected $table = 'data_tunggakan';
    protected $fillable = [
        'nokredit',
        'tunggakan_pokok',
        'tunggakan_bunga',
        'tunggakan_denda',
    ];

    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'nokredit', 'nokredit');
    }
}
