<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteMovie extends Component
{
    public $movieId;

    protected $listeners = [
        'openDeleteMovieModal' => 'loadMovie'
    ];

        /**
     * Loads an actor from the database based on the provided actor ID.
     *
     * @param int $movieId The ID of the movie to load.
     * @return void
     */
    public function loadMovie($movieId): void
    {
        $movie = Movie::find($movieId);
        $this->movieId = $movie->MovieID;
    }

        /**
     * Handles the delete of an selected movie.
     *
     * Deletes an movie from the database based on the movie ID then dispatches events to notify the frontend
     *
     * @return void
     *
     * @throws \Illuminate\Database\QueryException If a database error occurs during the actor creation. The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     * @throws \Exception If a general error occurs during the actor creation.  The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
     */
    public function deleteMovie(): void
    {
        try {
            DB::beginTransaction();

            $movie = Movie::find($this->movieId);
            $movie->delete();

            DB::commit();

            $this->dispatch('swalConfirmMsg');
            $this->dispatch('movieDeleted');

            Log::info('Movie deleted successfully', ['movie' => $movie]);


        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
            $this->dispatch('errorMovieDeleted', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.movies.delete-movie');
    }
}
