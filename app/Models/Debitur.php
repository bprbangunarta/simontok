<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debitur extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'm_loan';
}
