<?php

namespace App\Livewire\Movies;

use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMovie extends Component
{
    use WithFileUploads;

    public $title;

    public $duration;

    public $synopsis;

    public $mainActor;

    public $image;

    protected $rules = [
        'title' => 'required|min:3|max:50|string',
        'duration' => ['required', 'regex:/^\d{1,3}(:[0-5]\d)?$/'], // Valida "hh:mm" o solo minutos
        'synopsis' => 'required|string',
        'mainActor' => 'required',
        'image' => 'required|file|image|max:2048',
    ];

        /**
     * Handles the updated event for the component.
     *
     * @param string $propertyName The name of the property that was updated.
     * @return void
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

        /**
 * Handles the creation of a new movie.
 *
 * This method validates the incoming data, handles the image upload process,
 * and saves the movie information in the database. It also manages
 * transactions and logs events. If an error occurs, it handles the
 * exceptions and provides feedback via dispatch events.
 *
 * @return void
 *
 * @throws \Illuminate\Database\QueryException If a database error occurs during the actor creation. The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
 * @throws \Exception If a general error occurs during the actor creation.  The operation is rolled back and is logged, and an exception is thrown in a event to the frontend with an error message.
 */
    public function createMovie(): void
    {
        Log::info('Creating a new movie');

        try {
            $validateData = $this->validate();

            DB::beginTransaction();

            if ($this->image) {
                $imageName = $this->image->getClientOriginalName();
                $imageName = uniqid() . '_' . time() . $imageName;
                $imageName = str_replace(' ', '_', $imageName);
                $imageName = str_replace('#', '', $imageName);
                $path = $this->image->storeAs('public/images', $imageName);
                $imageUrl = Storage::url($path);
            }

            $movie = new Movie();
            $movie->Title = $validateData['title'];
            $movie->Duration = $validateData['duration'];
            $movie->Synopsis = $validateData['synopsis'];
            $movie->PrincipalActorID = $validateData['mainActor'];
            $movie->Image = $imageUrl;
            $movie->save();

            DB::commit();

            Log::info('Movie created successfully', ['movie' => $movie]);

            $this->dispatch('swalConfirmMsg');
            $this->dispatch('movieCreated');
            $this->reset();

        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('swalErrorMsg', ['message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.movies.create-movie', [
            'actors' => Actor::all(),
        ]);
    }
}
