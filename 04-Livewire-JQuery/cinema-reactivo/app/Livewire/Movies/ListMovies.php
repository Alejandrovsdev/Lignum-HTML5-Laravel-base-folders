<?php

namespace App\Livewire\Movies;

use App\Models\Actor;
use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class ListMovies extends Component
{
    use WithPagination;

    protected $listeners = [
        'movieCreated' => 'refresh',
        'movieUpdated' => 'refresh',
        'movieDeleted' => 'refresh',
    ];

    public function render()
    {
        return view('livewire.movies.list-movies', [
            'movies' => Movie::orderBy('MovieID', 'asc')->with('mainActor')->paginate(5),
            'actors' => Actor::all(),
        ]);
    }
}
