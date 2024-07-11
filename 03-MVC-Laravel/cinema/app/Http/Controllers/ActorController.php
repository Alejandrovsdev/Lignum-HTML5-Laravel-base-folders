<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActorController extends Controller
{

    public function index()
    {
        $actors = Actor::orderBy('actor_id', 'asc')->paginate(6);
        return view('admin.actors.index', compact('actors'));
    }

    public function create ()
    {
        return view('admin.actors.create');
    }

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

    public function show(Actor $actor)
    {
        return view('admin.actors.show', compact('actor'));
    }

    public function edit (Actor $actor) {
        return view("admin.actors.edit", compact("actor"));
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
        try {
            DB::beginTransaction();
            $actor->delete();
            DB::commit();
            return redirect()->route("admin-actors-index");
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

}
