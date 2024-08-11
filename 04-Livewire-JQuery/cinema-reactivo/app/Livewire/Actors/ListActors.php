<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;
use Livewire\WithPagination;

class ListActors extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortAsc;
    public $searchDateFrom;
    public $searchDateTo;

    protected $listeners = [
        'actorCreated' => 'refresh',
        'actorUpdated' => 'refresh',
        'actorDeleted' => 'refresh',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $actores = Actor::where(function ($search) {
            $search->where('Name', 'like', '%' . $this->search . '%');

            if ($this->searchDateFrom) {
                $search->whereDate('birthdate', '>=', $this->searchDateFrom);
            }

            if ($this->searchDateTo) {
                $search->whereDate('birthdate', '<=', $this->searchDateTo);
            }
        });

        if ($this->sortField) {
            $actores = $actores->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        $actores = $actores->paginate(5);


        return view('livewire.actors.list-actors', [
            'actores' => $actores
        ]);
    }
}
