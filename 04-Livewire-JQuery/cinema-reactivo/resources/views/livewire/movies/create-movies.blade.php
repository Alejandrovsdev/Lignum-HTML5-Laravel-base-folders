<div wire:ignore.self class="modal fade" id="createMovieModal" tabindex="-1" aria-labelledby="createMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="createMovieModalLabel">Create Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="createMovie">
                    <div>
                        <x-input-label for="title" :value="__('Movie Title')" />
                        <x-text-input wire:model.blur="title" id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus autocomplete="title" />
                        @error('title') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="duration" :value="__('Movie Duration (min)')" />
                        <x-text-input wire:model.blur="duration" id="duration" class="block mt-1 w-full" type="numeric" name="duration" />
                        @error('duration') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="synopsis" :value="__('Movie Synopsis')" />
                        <textarea wire:model.blur="synopsis" id="synopsis" class="block mt-1 w-full" name="synopsis" ></textarea>
                        @error('synopsis') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="mainActor" :value="__('Main Actor')" />
                        <select wire:model.blur="mainActor" name="mainActor" id="mainActor" class="block mt-1 w-full" >
                            <option value="">{{ __('Select an actor') }}</option>
                            @foreach ($actors as $actor)
                                <option value="{{ $actor->ActorID }}">{{ $actor->Name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('movie_principal_actor')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Movie Image')" class="mt-4"/>
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="movie image preview" width="200" height="250">
                        @endif
                        <x-text-input wire:model.blur="image" id="image" class="block mt-1 w-full" type="file" name="image" />
                        @error('image') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="modal-footer">
                        <x-primary-button class="ms-4" type="submit" data-bs-dismiss="modal">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
