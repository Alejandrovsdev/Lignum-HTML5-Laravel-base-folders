<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Movie;
use App\Models\MovieActor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $actors = Actor::all();
        $movies = Movie::orderBy('movie_id', 'asc')->paginate(6);
        return view('admin.movies.index', compact('movies', 'actors'));
    }

    public function create()
    {
        $actors = Actor::all();
        return view('admin.movies.create', compact('actors'));
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
                'movie_principal_actor' => 'required',
            ], [
                'movie_title.required' => 'the movie title is required',
                'movie_title.min' => 'the movie title has to be at least 2 characters',
                'movie_title.max' => 'the movie title has to be at most 50 characters',
                'movie_year.required' => 'the movie year is required',
                'movie_year.min' => 'the movie year must be at least 1895',
                'movie_year.max' => 'the movie year must be at most 2050',
                'movie_duration.required' => 'the movie duration is required',
                'movie_duration.regex' => 'The movie duration format is invalid',
                'movie_synopsis.required' => 'The movie synopsis is required',
                'movie_image.required' => 'The movie image is required',
                'movie_image.mimes' => 'The movie image must be a file of type: jpeg, png, jpg',
                'movie_image.max' => 'The movie image must not be greater than 2048 kilobytes',
                'movie_principal_actor.required' => 'The movie principal actor is required',
                'movie_principal_actor.exists' => 'The selected actor does not exist',

            ]);

            if ($req->hasFile('movie_image')) {
                $file = $req->file('movie_image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $imageName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('#', '', $imageName);
                $path = $file->storeAs('public/images', $imageName);
                $imageUrl = Storage::url($path);
            }

            $movie = Movie::create([
                'title' => $validateForm['movie_title'],
                'year' => $validateForm['movie_year'],
                'duration' => $validateForm['movie_duration'],
                'synopsis' => $validateForm['movie_synopsis'],
                'principal_actor_id' => $validateForm['movie_principal_actor'],
                'image' => $imageUrl,
            ]);

            MovieActor::create([
                'movie_id' => $movie->movie_id,
                'actor_id' => $validateForm['movie_principal_actor'],
            ]);

            DB::commit();
            //TODO: Session put para mensajes
            return redirect()->route("admin-movies-index");
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
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $actors = Actor::all();
        return view('admin.movies.edit', compact('actors', 'movie'));
    }

    public function update(Request $req, Movie $movie)
    {
        try {
            DB::beginTransaction();
            $validateForm = $req->validate([
                'movie_title' => 'required|min:2|max:50|string',
                'movie_year' => 'required|min:1895|max:2050|numeric',
                'movie_duration' => 'required', 'regex:/^\d{1,3}(:[0-5]\d)?$/', // Valida "hh:mm" o solo minutos
                'movie_synopsis' => 'required|string',
                'movie_image' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                'movie_principal_actor' => 'required',
            ], [
                'movie_title.required' => 'the movie title is required',
                'movie_title.min' => 'the movie title has to be at least 2 characters',
                'movie_title.max' => 'the movie title has to be at most 50 characters',
                'movie_year.required' => 'the movie year is required',
                'movie_year.min' => 'the movie year must be at least 1895',
                'movie_year.max' => 'the movie year must be at most 2050',
                'movie_duration.required' => 'the movie duration is required',
            ]);

            if ($req->hasFile('movie_image')) {
                $file = $req->file('movie_image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $imageName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('#', '', $imageName);
                $path = $file->storeAs('public/images', $imageName);
                $imageUrl = Storage::url($path);
            }

            $movie->update([
                'title' => $validateForm['movie_title'],
                'year' => $validateForm['movie_year'],
                'duration' => $validateForm['movie_duration'],
                'synopsis' => $validateForm['movie_synopsis'],
                'principal_actor_id' => $validateForm['movie_principal_actor'],
                'image' => $imageUrl,
            ]);

            MovieActor::updateOrCreate(
                ['movie_id' => $movie->movie_id],
                ['actor_id' => $validateForm['movie_principal_actor']]
            );


            DB::commit();
            return redirect()->route("admin-movies-index");
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            DB::beginTransaction();
            $movie->delete();
            DB::commit();
            return redirect()->route("admin-movies-index");
        } catch (QueryException $e) {
            DB::rollBack();
            abort(500, 'Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            abort(500, 'Error al guardar datos: ' . $e->getMessage());
        }
    }

    public function addMovieToFavorite(Movie $movie)
    {
        $movie->update(["is_favorite" => 1]);
        return response()->json(["message" => "Película añadida a favoritos.", "is_favorite" => 1]);
    }

    public function removeMovieFromFavorite(Movie $movie)
    {
        $movie->update(["is_favorite" => 0]);
        return response()->json(["message" => "Película quitada de favoritos.", "is_favorite" => 0]);
    }

    public function showFavoritesMovies()
    {
        $favorites = Movie::where('is_favorite', 1)->get();
        return response()->json(["is_favorite" => $favorites]);
    }
}
