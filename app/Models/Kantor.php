<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    use HasFactory;

    protected $table = 'data_kantor';
    protected $fillable = [
        'kode',
        'nama',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'kantor_id', 'id');
    }
}
