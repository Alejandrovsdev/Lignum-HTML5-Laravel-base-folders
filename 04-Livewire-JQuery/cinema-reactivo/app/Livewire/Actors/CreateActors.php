<?php

namespace App\Livewire\Actors;

use App\Models\Actor;
use Exception;
use Illuminate\Database\QueryException;
use Livewire\Component;

class CreateActors extends Component
{
    #[Validate]
    public $name;

    #[Validate]
    public $birthdate;

    public function createActor () {
        try {
            $validateData = $this->validate([
                'name' => 'required|string|max:50|min:3',
                'birthdate' => 'required|date'
            ],[
                'name.required' => 'the name of the actor is required',
                'name.min' => 'the actor name most be at least 3 characters',
                'name.max' => 'the actor name most be at most 50 characters',
                'birthdate.required' => 'the actor birthdate is required',
            ]);

            DB::beginTransaction();

            $actor = new Actor();
            $actor->name = $validateData['actor_name'];
            $actor->birthdate = $validateData['actor_birthdate'];

            $actor->save();
            $this->emit('actorCreated');
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
        return view('livewire.actors.create-actors');
    }
}
