<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'MovieID';

    public function mainActor()
    {
        return $this->belongsTo(Actor::class, 'PrincipalActorID', 'ActorID', 'MovieID');
    }

    public function categoryMovies()
    {
        return $this->hasMany(Category::class, 'MovieCategoryID');
    }

    public function categories()
    {
        return $this->hasManyThrough(
            Category::class,
            MovieCategory::class,
            'MovieID',
            'CategoryID',
            'MovieID',
            'CategoryID'
        );
    }
}
