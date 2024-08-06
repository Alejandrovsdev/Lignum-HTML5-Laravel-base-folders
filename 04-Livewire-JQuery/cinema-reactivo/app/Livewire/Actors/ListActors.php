<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;
use Livewire\WithPagination;

class ListActors extends Component
{
    use WithPagination;

    protected $listeners = [
        'actorCreated' => 'refresh',
        'actorUpdated' => 'refresh',
        'actorDeleted' => 'refresh',
    ];

    public function render()
    {
        return view('livewire.actors.list-actors', [
            'actores' => Actor::orderBy('ActorID', 'asc')->paginate(5),
        ]);
    }
}
