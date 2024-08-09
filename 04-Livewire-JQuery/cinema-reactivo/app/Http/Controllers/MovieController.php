<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{

    /**
     * Displays the dashboard for actors and movies.
     *
     * This function retrieves the actors and movies from the database,
     * paginates them, and passes them to the 'admin.dashboard-content' view.
     *
     * @return View
     */
    public function showDashboardActorsAndMovies(): View
    {
        $actors = Actor::orderBy('ActorID', 'asc')->paginate(5);
        $movies = Movie::orderBy('MovieID', 'asc')->paginate(5);
        return view('admin.dashboard-content', compact('actors', 'movies'));
    }

    /**
     * Retrieves a movie by its ID and returns it as a JSON response.
     *
     * @param int $movieId The ID of the movie to retrieve.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the movie data.
     */
    public function getMovie($movieId): JsonResponse
    {
        $movie = Movie::find($movieId)->only([
            'MovieID',
            'Title',
            'Duration',
            'Synopsis',
            'PrincipalActorID',
            'Image'
        ]);
        return response()->json(['movie' => $movie]);
    }

    /**
     * Updates a movie in the database.
     *
     * This function takes a Request object and a movie ID, validates the request data,
     * updates the movie with the new data, and returns the updated movie as JSON.
     *
     * @param Request $req The incoming request object.
     * @param int $movieId The ID of the movie to update.
     * @throws \Illuminate\Database\QueryException If a database error occurs during the actor creation. The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     * @throws \Exception If a general error occurs during the actor creation.  The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     * @return JsonResponse The updated movie data as JSON.
     */
    public function updateMovie(Request $req, $movieId): JsonResponse
    {
        try {
            $movie = Movie::find($movieId); //TODO: Usar find y un error controlado

            $validateData = $req->validate([
                'title' => 'required|min:3|max:50|string',
                'duration' => 'required',
                'regex:/^\d{1,3}(:[0-5]\d)?$/', // Valida "hh:mm" o solo minutos
                'synopsis' => 'required|string',
                'image' => 'nullable|file|image|max:2048',
                'mainActor' => 'required',
            ]);

            DB::beginTransaction();

            $imageUrl = $movie->Image;

            if ($req->hasFile('image')) {
                if ($imageUrl && Storage::exists(str_replace('/storage/', 'public/', $imageUrl))) {
                    Storage::delete(str_replace('/storage/', 'public/', $imageUrl));
                }

                $imageName = $req->file('image')->getClientOriginalName();
                $imageName = uniqid() . '_' . time() . $imageName;
                $imageName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('#', '', $imageName);
                $path = $req->file('image')->storeAs('public/images', $imageName);
                $imageUrl = Storage::url($path);
            }

            $movie->Title = $validateData['title'];
            $movie->Duration = $validateData['duration'];
            $movie->Synopsis = $validateData['synopsis'];
            $movie->PrincipalActorID = $validateData['mainActor'];
            $movie->Image = $imageUrl;

            $movie->save();

            $movie->nameActor = $movie->mainActor->Name;

            $movie = $movie->only([
                'MovieID',
                'Title',
                'Duration',
                'Synopsis',
                'PrincipalActorID',
                'Image',
                'nameActor'
            ]);

            DB::commit();
            return response()->json([
                'movie' => $movie
            ]);
        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['database' => 'Database error: ' . $e->getMessage()]]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['errors' => ['general' => 'Error saving data: ' . $e->getMessage()]]);
        }
    }
}
