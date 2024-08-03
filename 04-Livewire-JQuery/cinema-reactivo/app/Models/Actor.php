<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'ActorID';

    protected $dates = ['Birthdate'];

    public function principalMovies()
    {
        return $this->hasMany(Movie::class, 'PrincipalActorID');
    }

    public function getBirthdateAttribute($date)
    {
        return Carbon::parse($date)->format('d-m-Y');
    }

    public function setBirthdateAttribute($date)
    {
        $this->attributes['Birthdate'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }
}
