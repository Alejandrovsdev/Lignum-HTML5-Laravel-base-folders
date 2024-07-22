<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Livewire\Component;
use Livewire\WithPagination;

class ListMovies extends Component
{
    use WithPagination;

    public $moviess;

    protected $listeners = [
        'MovieCreated' => 'refreshMovies',
        'MovieUpdated' => 'refreshMovies',
        'MovieDeleted' => 'refreshMovies',
        'errorCreated' => 'errorAlert',
        'errorUpdated' => 'errorAlert',
        'errorDeleted' => 'errorAlert',
    ];

    public function refreshMovies() {
        $this->moviess = Movie::orderBy('MovieID', 'asc')->get();
        session()->flash('success', 'Operation Sucecessfully Completed');
    }

    public function errorAlert($data) {
        session()->flash('error', $data['message']);
    }

    public function render()
    {
        return view('livewire.movies.list-movies', [
            'movies' => Movie::orderBy('MovieID', 'asc')->paginate(5),
        ])->layout('layouts.app');
    }
}
