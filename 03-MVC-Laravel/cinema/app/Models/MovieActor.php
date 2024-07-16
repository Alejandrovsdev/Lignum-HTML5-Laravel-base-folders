<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieActor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'movie_actor_id';
    protected $table = 'movie_actor';

    protected $fillable = [
        'movie_id',
        'actor_id',
    ];
}
