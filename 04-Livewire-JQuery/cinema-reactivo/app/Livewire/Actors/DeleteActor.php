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

    /**
     * Loads an actor from the database based on the provided actor ID.
     *
     * @param int $actorId The ID of the actor to load.
     * @return void
     */
    public function loadActor($actorId): void
    {
        $actor = Actor::find($actorId);
        $this->actorId = $actor->ActorID;
    }

    /**
     * Handles the delete of an selected actor.
     *
     * Deletes an actor from the database based on the actor ID then dispatches events to notify the frontend
     *
     * @return void
     *
     * @throws \Illuminate\Database\QueryException If a database error occurs during the actor creation. The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     * @throws \Exception If a general error occurs during the actor creation.  The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     */
    public function deleteActor(): void
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
