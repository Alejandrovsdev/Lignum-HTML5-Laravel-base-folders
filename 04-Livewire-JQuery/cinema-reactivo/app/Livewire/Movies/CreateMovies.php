<?php

namespace App\Livewire\Movies;

use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMovies extends Component
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createMovie() {
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

            $this->dispatch('movieCreated');
            $this->reset();

        } catch (QueryException $e) {
            DB::rollback();
            Log::error('Database error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorCreated', ['message' => 'Database error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('General error', ['message' => $e->getMessage(), 'exception' => $e]);
            $this->dispatch('errorCreated', ['message' => 'Error saving data: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.movies.create-movies', [
            'actors' => Actor::all(),
        ]);
    }
}
