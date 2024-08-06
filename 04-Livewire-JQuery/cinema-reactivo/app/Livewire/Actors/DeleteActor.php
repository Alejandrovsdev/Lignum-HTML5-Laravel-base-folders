<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteActor extends Component
{
    public $actorId;

    protected $listeners = [
        'openDeleteActorModal' => 'loadActor'
    ];

    public function loadActor($actorId)
    {
        $actor = Actor::find($actorId);
        $this->actorId = $actor->ActorID;
    }

    public function deleteActor()
    {
        try {
            DB::beginTransaction();

            $actor = Actor::find($this->actorId);
            $actor->delete();

            DB::commit();

            $this->dispatch('swalConfirmMsg');
            $this->dispatch('actorDeleted');

            Log::info('Actor deleted successfully', ['actor' => $actor]);


        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.actors.delete-actor');
    }
}
