<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function principalActor()
    {
        return $this->belongsTo(Actor::class, 'PrincipalActorID', 'ActorID', 'MovieID');
    }
}
