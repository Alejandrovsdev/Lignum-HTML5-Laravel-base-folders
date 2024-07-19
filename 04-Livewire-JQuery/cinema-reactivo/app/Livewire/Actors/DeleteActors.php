<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Livewire\Component;

class DeleteActors extends Component
{
    public $actorId;

    protected $listeners = [
        'openDeleteActorModal' => 'loadActor'
    ];

    public function loadActor($actorId)
    {
        $actor = Actor::findOrFail($actorId);
        $this->actorId = $actor->ActorID;
    }

    public function deleteActor($actorId)
    {
        try {
            DB::beginTransaction();

            $actor = Actor::findOrFail($actorId);
            $actor->delete();
            $this->emit('actorDeleted');

            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollback();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.actors.delete-actors');
    }
}
