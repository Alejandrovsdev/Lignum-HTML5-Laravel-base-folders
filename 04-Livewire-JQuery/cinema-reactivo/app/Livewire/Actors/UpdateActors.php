<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateActors extends Component
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

    public function loadActor($actorId)
    {
        $actor = Actor::findOrFail($actorId);
        $this->actorId = $actor->ActorID;
        $this->name = $actor->Name;
        $this->birthdate = $actor->Birthdate;
    }

    public function updateActor() {

        Log::info('Updating current actor');

        try {
            $validateData = $this->validate();

            DB::beginTransaction();

            $actor = Actor::findOrFail($this->actorId);
            $actor->Name = $validateData['name'];
            $actor->Birthdate = $validateData['birthdate'];

            $actor->save();
            DB::commit();

            Log::info('Actor updated successfully', ['actor' => $actor]);

            $this->dispatch('actorUpdated');
        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorUpdated', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorUpdated', ['message' => 'Error saving data: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.actors.update-actors');
    }
}
