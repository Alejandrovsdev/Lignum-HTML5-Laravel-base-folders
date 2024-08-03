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
        'movieCreated' => 'refreshMovies',
        'movieUpdated' => 'refreshMovies',
        'movieDeleted' => 'refreshMovies',
        'errorMovieCreated' => 'errorAlert',
        'errorMovieUpdated' => 'errorAlert',
        'errorMovieDeleted' => 'errorAlert',
    ];

    public function refreshMovies() {
        session()->flash('success', 'Operation Sucecessfully Completed');
    }

    public function errorAlert($data) {
        session()->flash('error', $data['message']);
    }

    public function render()
    {
        return view('livewire.movies.list-movies', [
            'movies' => Movie::orderBy('MovieID', 'asc')->paginate(5),
            'actors' => Actor::all(),
        ]);
    }
}
