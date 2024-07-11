<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActorController extends Controller
{

    public function index()
    {
        $actors = Actor::orderBy('id', 'asc')->paginate(6);
        return view("actors.index", compact("actors"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function submit(Request $req)
    {
        try {
            DB::beginTransaction();
            $validateForm = $req->validate([
                'actor_name' => 'required|min:3|max:50|string',
                'actor_birthdate' => 'required|date',
            ], [
                'actor_name.required' => 'the name of the actor is required',
                'actor_name.min' => 'the actor name most be at least 3 characters',
                'actor_name.max' => 'the actor name most be at most 50 characters',
                'actor_birthdate.required' => 'the actor birth date is required',
            ]);


            Actor::create([
                'name' => $validateForm['actor_name'],
                'birthdate' => $validateForm['actor_birthdate'],
            ]);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $req, $actorId)
    {
        try {
            DB::beginTransaction();
            $validateForm = $req->validate([
                'actor_name' => 'required|min:3|max:50|string',
                'actor_birthdate' => 'required|date',
            ], [
                'actor_name.required' => 'the name of the actor is required',
                'actor_name.min' => 'the actor name most be at least 3 characters',
                'actor_name.max' => 'the actor name most be at most 50 characters',
                'actor_birthdate.required' => 'the actor birth date is required',
            ]);

            $actor = Actor::where('actor_id', $actorId)->firstOrFail();

            $actor->update([
                'name' => $validateForm['actor_name'],
                'birthdate' => $validateForm['actor_birthdate'],
            ]);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return redirect()->route('');
    }

}
