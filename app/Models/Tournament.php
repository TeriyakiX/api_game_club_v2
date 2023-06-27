<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'Tournament';

    protected  $fillable =[
        'id',
        'game',
        'Short_description',
        'description',
        'date_start',
        'date_end',
        'prize',
        'type_id',
        'status_id',
        'updated_at',
        'created_at',

    ];
    public function applications()
    {
        return $this->hasMany(Applications_the_tournament::class);
    }
}
