<?php

namespace App\Livewire\Movies;

use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListMovies extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc;

    protected $listeners = [
        'movieCreated' => 'refresh',
        'movieUpdated' => 'refresh',
        'movieDeleted' => 'refresh',
    ];

    /**
     * Sorts the data by the given field.
     *
     * @param string $field The field to sort by.
     * @return void
     */
    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    /**
     * Reset the page when the search value is being updated.
     *
     * @return void
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Renders the list of movies based on the search query and sorting options.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        $movies = Movie::whereHas('mainActor', function ($query) {
            $query->where('Title', 'like', '%' . $this->search . '%')
                ->orWhere('Name', 'like', '%' . $this->search . '%');
        });

        if ($this->sortField === 'mainActor.Name') {
            $movies = $movies->whereHas('mainActor', function ($actorQuery) {
                $actorQuery->orderBy('Name', $this->sortAsc ? 'asc' : 'desc');
            });
        } elseif ($this->sortField) {
            $movies = $movies->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        $movies = $movies->with('mainActor')->paginate(5);

        return view('livewire.movies.list-movies', [
            'movies' => $movies,
            'actors' => Actor::all(),
        ]);
    }
}
