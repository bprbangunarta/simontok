<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;

    protected $table = 'data_resign';
    protected $primaryKey = 'nokaryawan, namakaryawan';

    public function kredit()
    {
        return $this->belongsTo(Kredit::class, 'nokaryawan', 'nokaryawan');
    }
}
