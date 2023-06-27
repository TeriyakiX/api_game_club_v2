<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications_the_tournament extends Model
{
    use HasFactory;

    protected $table = 'applications_the_tournament';

    protected  $fillable =[
        'id',
        'tournament_id',
        'user_id',
        'name',
        'email',
        'phone',
        'id_approved_or_not',
        'created_at',
        'updated_at',
    ];
    protected $tournament_id;

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
