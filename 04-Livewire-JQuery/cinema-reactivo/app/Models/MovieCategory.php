<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieCategory extends Pivot
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = true;
    protected $table = 'movie_categories';

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'MovieID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

}
