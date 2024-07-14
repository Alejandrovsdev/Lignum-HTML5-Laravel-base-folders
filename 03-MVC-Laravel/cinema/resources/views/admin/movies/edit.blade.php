<x-guest-layout>
    <form method="POST" action="{{ route('admin-movies-update', ['movie' => $movie]) }}" enctype="multipart/form-data">
        @method("PUT")
        @csrf

        <div>
            <x-input-label for="movie_title" :value="__('Movie Title')" />
            <x-text-input id="movie_title" class="block mt-1 w-full" type="text" name="movie_title" value="{{ $movie->title }}" required/>
            <x-input-error :messages="$errors->get('movie_title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_duration" :value="__('Movie Duration')" />
            <x-text-input id="movie_duration" class="block mt-1 w-full" type="text" name="movie_duration" value="{{ $movie->duration }}" required/>
            <x-input-error :messages="$errors->get('movie_duration')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_year" :value="__('Movie Year')" />
            <x-text-input id="movie_year" class="block mt-1 w-full" type="number" name="movie_year" value="{{ $movie->year }}" required/>
            <x-input-error :messages="$errors->get('movie_year')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_synopsis" :value="__('Movie Synopsis')" />
            <textarea id="movie_synopsis" class="block text-gray-300 bg-gray-900 mt-1 w-full rounded-md shadow-sm border-gray-600focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:ring-opacity-50" name="movie_synopsis" placeholder="{{ $movie->synopsis }}" required></textarea>
            <x-input-error :messages="$errors->get('movie_synopsis')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="movie_principal_actor" :value="__('Principal Actor')" />
            <select name="movie_principal_actor" id="movie_principal_actor" class="block mt-1 w-full bg-gray-900 text-gray-300" required>
                <option value="">{{  __('Select an actor') }}</option>
                @foreach ($actors as $actor)
                    <option value="{{ $actor->actor_id }}" @selected($movie->principalActor->actor_id == $actor->actor_id)>{{ $actor->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('movie_principal_actor')" class="mt-2" />
        </div>

        {{-- TODO: Hacer que me traiga el valor del actor principal seleccionado en la pelicula --}}

        <div class="mt-4">
            <x-input-label for="movie_image" :value="__('Movie Image')" />
            @if ($movie->image)
                <img src="{{ asset($movie->image) }}" alt="Current Movie Image" class="block mt-1 w-full mb-4" style="max-width: 300px; max-height:300px;">
            @endif
            <x-text-input id="movie_image" class="block mt-1 w-full" type="file" name="movie_image" value="{{ $movie->image }}" required />
            <x-input-error :messages="$errors->get('movie_image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-secondary-button class="ms-4" type="submit">
                {{ __('Update') }}
            </x-secondary-button>
        </div>
    </form>
</x-guest-layout>
