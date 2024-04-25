<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'data_produk';
    protected $fillable = [
        'no',
        'kode',
        'produk',
    ];

    public function kredit()
    {
        return $this->hasMany(Kredit::class, 'produk_id', 'id');
    }
}
