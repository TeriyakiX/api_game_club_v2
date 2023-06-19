<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'News';

    protected  $fillable =[
        'id',
        'name',
        'description',
        'date',
        'updated_at',
        'created_at'
    ];

}
