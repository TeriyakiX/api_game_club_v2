<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'Tournament';

    protected  $fillable =[
        'id',
        'name',
        'date',
        'prize'
    ];
}
