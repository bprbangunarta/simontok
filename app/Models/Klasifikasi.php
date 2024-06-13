<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    use HasFactory;
    protected $table = 'data_klasifikasi';

    protected $fillable = [
        'nokredit',
        'klasifikasi',
    ];

    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'nokredit', 'nokredit');
    }
}
