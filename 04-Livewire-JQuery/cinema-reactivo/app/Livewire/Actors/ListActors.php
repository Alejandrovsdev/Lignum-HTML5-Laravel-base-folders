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
        'errorCreated' => 'errorAlert',
        'errorUpdated' => 'errorAlert',
        'errorDeleted' => 'errorAlert',
    ];

    public function refreshActors() {
        session()->flash('success', 'Operation Sucecessfully Completed');
    }

    public function errorAlert($data) {
        session()->flash('error', $data['message']);
    }

    public function render()
    {
        return view('livewire.actors.list-actors', [
            'actores' => Actor::orderBy('ActorID', 'asc')->paginate(5),
        ]);
    }
}
