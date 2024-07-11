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
        'is_favorite',
    ];

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function principalActor()
    {
        return $this->belongsTo(Actor::class, 'actor_principal_id');
    }
}
