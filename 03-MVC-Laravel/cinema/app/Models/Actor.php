<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'actor_id';

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_actor');
    }

    public function principalMovies()
    {
        return $this->hasMany(Movie::class, 'actor_principal_id');
    }
}
