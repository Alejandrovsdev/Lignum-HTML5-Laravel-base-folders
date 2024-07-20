<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;
use Livewire\WithPagination;

class ListActors extends Component
{
    use WithPagination;

    public $actors;

    protected $listeners = [
        'actorCreated' => 'refreshActors',
        'actorUpdated' => 'refreshActors',
        'actorDeleted' => 'refreshActors',
    ];

    public function refreshActors() {
        $this->actors = Actor::orderBy('ActorID', 'asc')->get();
        session()->flash('success', 'Operation Sucecessfully Completed');
    }

    public function render()
    {
        return view('livewire.actors.list-actors', [
            'actores' => Actor::orderBy('ActorID', 'asc')->paginate(5),
        ])->layout('layouts.app');
    }
}
