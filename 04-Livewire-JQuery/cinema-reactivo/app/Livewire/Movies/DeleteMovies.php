<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteMovies extends Component
{
    public $movieId;

    protected $listeners = [
        'openDeleteMovieModal' => 'loadMovie'
    ];

    public function loadMovie($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $this->movieId = $movie->MovieID;
    }

    public function deleteMovie()
    {
        try {
            DB::beginTransaction();

            $movie = Movie::findOrFail($this->movieId);
            $movie->delete();

            DB::commit();
            $this->dispatch('movieDeleted');

            Log::info('Movie deleted successfully', ['movie' => $movie]);


        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorMovieDeleted', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorMovieDeleted', ['message' => 'Error saving data: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.movies.delete-movies');
    }
}
