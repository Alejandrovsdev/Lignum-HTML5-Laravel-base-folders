<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'ActorID';

    public function principalMovies()
    {
        return $this->hasMany(Movie::class, 'PrincipalActorID');
    }

    protected $casts = [
        'birthday' => 'datetime:d-m-Y'
    ];
}
