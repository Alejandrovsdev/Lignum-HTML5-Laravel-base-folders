<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::all();
        $movies = Movie::orderBy("id", "asc")->paginate(6);
        return view("movies.index", compact("movies", "actors"));
    }

    public function submit(Request $req)
    {
        try {
            DB::beginTransaction();
            $validateForm = $req->validate([
                'movie_title' => 'required|min:2|max:50|string',
                'movie_year' => 'required|min:1895|max:2050|numeric',
                'movie_duration' => 'required', 'regex:/^\d{1,3}(:[0-5]\d)?$/', // Valida "hh:mm" o solo minutos
                'movie_synopsis' => 'required|string',
                'movie_image' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                'movie_principal_actor' => 'required|string|min:2|max:50',
            ], [
                'movie_title.required' => 'the movie title is required',
                'movie_title.min' => 'the movie title has to be at least 2 characters',
                'movie_title.max' => 'the movie title has to be at most 50 characters',
                'movie_year.required' => 'the movie year is required',
                'movie_year.min' => 'the movie year must be at least 1895',
                'movie_year.max' => 'the movie year must be at most 2050',
                'movie_duration.required' => 'the movie duration is required',
                //TODO: terminar con los mensajes de validación
            ]);

            //TODO: Almacenar la imagen

            $movie = Movie::create([
                'title' => $validateForm['movie_title'],
                'year' => $validateForm['movie_year'],
                'duration' => $validateForm['movie_duration'],
                'synopsis' => $validateForm['movie_synopsis'],
                'image' => $validateForm['movie_image'],
            ]);
            MovieActor::create([
                'movie_id' => $movie->movie_id,
                'actor_id' => $validateForm['movie_principal_actor'],
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

    public function show(Movie $movie)
    {
        return view('', compact('movie'));
    }

    public function update(Request $req, $movieId)
    {
        try {
            DB::beginTransaction();
            $validateForm = $req->validate([
                'movie_title' => 'required|min:2|max:50|string',
                'movie_year' => 'required|min:1895|max:2050|numeric',
                'movie_duration' => 'required', 'regex:/^\d{1,3}(:[0-5]\d)?$/', // Valida "hh:mm" o solo minutos
                'movie_synopsis' => 'required|string',
                'movie_image' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                'movie_principal_actor' => 'required|string|min:2|max:50',
            ], [
                'movie_title.required' => 'the movie title is required',
                'movie_title.min' => 'the movie title has to be at least 2 characters',
                'movie_title.max' => 'the movie title has to be at most 50 characters',
                'movie_year.required' => 'the movie year is required',
                'movie_year.min' => 'the movie year must be at least 1895',
                'movie_year.max' => 'the movie year must be at most 2050',
                'movie_duration.required' => 'the movie duration is required',
                //TODO: terminar con los mensajes de validación
            ]);

            $movie = Movie::where('movie_id', $movieId)->firstOrFail();

            $movie->update([
                'title' => $validateForm['movie_title'],
                'year' => $validateForm['movie_year'],
                'duration' => $validateForm['movie_duration'],
                'synopsis' => $validateForm['movie_synopsis'],
                'image' => $validateForm['movie_image'],
            ]);

            MovieActor::updateOrCreate(
                ['movie_id' => $movie->movie_id],
                ['actor_id' => $validateForm['movie_principal_actor']]
            );


            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route("/");
    }

        public function addMovieToFavorite(Movie $movie)
    {
        $movie->update(["is_favorite" => 1]);
        return response()->json(["message" => "Película añadida a favoritos.", "is_favorite" => 1]);
    }

    public function removeMovieFromFavorite(Movie $movie)
    {
        $movie->update(["is_favorite" => 0]);
        return response()->json(["message" => "Película quitada de favoritos.","is_favorite" => 0]);
    }

    public function showFavoritesMovies()
    {
        $favorites = Movie::where('is_favorite', 1)->get();
        return response()->json(["is_favorite" => $favorites]);
    }
}
