<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'movie_id';

    protected $fillable = [
        'title',
        'year',
        'duration',
        'synopsis',
        'image',
        'principal_actor_id',
        'is_favorite',
    ];

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor', 'actor_id', 'movie_id' );
    }

    public function principalActor()
    {
        return $this->belongsTo(Actor::class, 'principal_actor_id', 'actor_id', 'movie_id');
    }
}
