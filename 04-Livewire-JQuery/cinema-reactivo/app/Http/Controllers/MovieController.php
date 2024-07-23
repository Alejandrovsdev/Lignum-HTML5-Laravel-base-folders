<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function getMovie($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        return response()->json(['movie' => $movie]);
    }

    public function updateMovie(Request $req, $movieId)
    {
        try {
            $movie = Movie::findOrFail($movieId);

            $validateData = $req->validate([
                'title' => 'required|min:3|max:50|string',
                'duration' => 'required', 'regex:/^\d{1,3}(:[0-5]\d)?$/', // Valida "hh:mm" o solo minutos
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

            DB::commit();
            return response()->json(['message' => 'Movie updated successfully']);
        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            return response()->json(['message' => 'Error saving data: ' . $e->getMessage()]);
        }
    }
}
