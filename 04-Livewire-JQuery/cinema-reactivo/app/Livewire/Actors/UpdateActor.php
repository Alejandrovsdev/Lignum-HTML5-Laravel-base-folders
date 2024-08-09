<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateActor extends Component
{
    public $actorId;
    public $name;
    public $birthdate;

    protected $rules = [
        'name' => 'required|string|max:50|min:3',
        'birthdate' => 'required|date',
    ];

    protected $messages = [
        'name.required' => 'The name of the actor is required',
        'name.min' => 'The actor name must be at least 3 characters',
        'name.max' => 'The actor name must be at most 50 characters',
        'birthdate.required' => 'The actor birthdate is required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $listeners = ['openUpdateActorModal' => 'loadActor'];

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
        $this->name = $actor->Name;
        $this->birthdate = Carbon::parse($actor->Birthdate)->format('Y-m-d');
    }

    /**
     * Handles the update of an selected actor.
     *
     * This method validates the input data, attempts to the actor record in the database,
     * and handles any errors that may occur during the process. If successful, it dispatches events
     * to notify the frontend and change the data in the table.
     *
     * @return void
     *
     * @throws \Illuminate\Database\QueryException If a database error occurs during the actor creation. The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     * @throws \Exception If a general error occurs during the actor creation.  The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     */
    public function updateActor(): void
    {

        Log::info('Updating current actor');

        try {
            $validateData = $this->validate();

            DB::beginTransaction();

            $actor = Actor::find($this->actorId);
            $actor->Name = $validateData['name'];
            $actor->Birthdate = Carbon::createFromFormat('Y-m-d', $validateData['birthdate'])->format('d-m-Y');

            $actor->save();
            DB::commit();

            Log::info('Actor updated successfully', ['actor' => $actor]);

            $this->dispatch('swalConfirmMsg');
            $this->dispatch('actorUpdated');
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
        return view('livewire.actors.update-actor');
    }
}
