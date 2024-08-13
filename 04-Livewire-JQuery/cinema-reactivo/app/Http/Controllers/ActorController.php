<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActorController extends Controller
{
    /**
     * Retrieves a list of actors in ascending order by ActorID and returns a view with the paginated results.
     *
     * @return View The view containing the paginated list of actors.
     */
    public function listActors(): View
    {
        $actors = Actor::orderBy('ActorID', 'asc')->with('actorCountry')->paginate(6);
        return view('admin.jq-crud.list-actors', compact('actors'));
    }

    /**
     * Creates a new actor based on the provided request data.
     *
     * @param Request $request The request object containing the actor data.
     * @throws Exception If a general error occurs during actor creation.
     * @throws QueryException If a database error occurs during actor creation.
     * @return JsonResponse The created actor data in JSON format.
     */
    public function createActor(Request $request): JsonResponse
    {
        $validateData = $request->validate([
            'name' => 'required',
            'birthdate' => 'required',
            'country' => 'required'
        ]);

        try {
            $actor = new Actor();
            $actor->Name = $validateData['name'];
            $actor->Birthdate =  Carbon::createFromFormat('Y-m-d', $validateData['birthdate'])->format('d-m-Y');
            $actor->ActorCountryID = $validateData['country'];
            $actor->save();

            $actor = $actor->only([
                'ActorID',
                'Name',
                'Birthdate',
                'CountryName'
            ]);

            $actor->CountryName = $actor->actorCountry->CountryName;
        } catch (Exception $e) {
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['general' => 'Error saving data: ' . $e->getMessage()]]);
        } catch (QueryException $e) {
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['database' => 'Database error: ' . $e->getMessage()]]);
        }

        return response()->json(['actor' => $actor]);
    }

    /**
     * Retrieves an actor by their ID and returns their data in JSON format.
     *
     * @param int $actorId The ID of the actor to retrieve.
     * @return JsonResponse The actor data in JSON format.
     */
    public function getActor($actorId): JsonResponse
    {
        $actor = Actor::find($actorId)->only([
            'ActorID',
            'Name',
            'Birthdate',
            'ActorCountryID'
        ]);

        $actor->CountryName = $actor->actorCountry->CountryName;
        return response()->json(['actor' => $actor]);
    }

    /**
     * Updates an existing actor based on the provided request data.
     *
     * @param Request $req The request object containing the actor data.
     * @param int $actorId The ID of the actor to update.
     * @throws QueryException If a database error occurs during actor update.
     * @throws Exception If a general error occurs during actor update.
     * @return JsonResponse The updated actor data in JSON format.
     */
    public function updateActor(Request $req, $actorId): JsonResponse
    {
        try {
            $actor = Actor::find($actorId);

            $validateData = $req->validate([
                'name' => 'required',
                'birthdate' => 'required',
                'country' => 'required'
            ]);

            $actor->Name = $validateData['name'];
            $actor->Birthdate =  Carbon::createFromFormat('Y-m-d', $validateData['birthdate'])->format('d-m-Y');
            $actor->ActorCountryID = $validateData['country'];

            $actor->save();

            $actor->CountryName = $actor->actorCountry->CountryName;

            return response()->json([
                'actor' => $actor
            ]);
        } catch (QueryException $e) {
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['database' => 'Database error: ' . $e->getMessage()]]);
        } catch (Exception $e) {
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['general' => 'Error saving data: ' . $e->getMessage()]]);
        }
    }
}
