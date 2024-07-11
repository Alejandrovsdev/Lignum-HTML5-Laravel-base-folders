<x-guest-layout>
    <form method="POST" action="{{ route('admin-movies-submit') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="movie_title" :value="__('Movie Title')" />
            <x-text-input id="movie_title" class="block mt-1 w-full" type="text" name="movie_title" required/>
            <x-input-error :messages="$errors->get('movie_title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_duration" :value="__('Movie Duration')" />
            <x-text-input id="movie_duration" class="block mt-1 w-full" type="text" name="movie_duration" required/>
            <x-input-error :messages="$errors->get('movie_duration')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_year" :value="__('Movie Year')" />
            <x-text-input id="movie_year" class="block mt-1 w-full" type="number" name="movie_year" required/>
            <x-input-error :messages="$errors->get('movie_year')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="movie_synopsis" :value="__('Movie Synopsis')" />
            <x-text-input id="movie_synopsis" class="block mt-1 w-full" type="text" name="movie_synopsis" required/>
            <x-input-error :messages="$errors->get('movie_synopsis')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="movie_principal_actor" :value="__('Principal Actor')" />
            <select name="movie_principal_actor" id="movie_principal_actor" class="block mt-1 w-full" required>
                <option value="">{{ __('Select an actor') }}</option>
                @foreach ($actors as $actor)
                    <option value="{{ $actor->actor_id }}">{{ $actor->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('movie_principal_actor')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="movie_image" :value="__('Movie Image')" />
            <x-text-input id="movie_image" class="block mt-1 w-full" type="file" name="movie_image" required />
            <x-input-error :messages="$errors->get('movie_image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-secondary-button class="ms-4" type="submit">
                {{ __('Create') }}
            </x-secondary-button>
        </div>
    </form>
</x-guest-layout>
