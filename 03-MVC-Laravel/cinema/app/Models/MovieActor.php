<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieActor extends Model
{
    use HasFactory;

    protected $primaryKey = 'movie_actor_id';
    protected $table = 'MovieActor';

    protected $fillable = [
        'movie_id',
        'actor_id',
    ];
}
