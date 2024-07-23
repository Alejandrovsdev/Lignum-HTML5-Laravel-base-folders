<div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray-500">
                <h5 class="modal-title text-white" id="editMovieModalLabel">Edit Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-movie-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="movieId" id="edit-movie-id">
                    <div>
                        <x-input-label for="edit-title" :value="__('Movie Title')" />
                        <x-text-input id="edit-title" class="block mt-1 w-full" type="text" name="title" autofocus
                            autocomplete="title" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit-duration" :value="__('Movie Duration (min)')" />
                        <x-text-input id="edit-duration" class="block mt-1 w-full" type="text" name="duration" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit-synopsis" :value="__('Movie Synopsis')" />
                        <textarea id="edit-synopsis" class="block mt-1 w-full" name="synopsis"></textarea>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="edit-mainActor" :value="__('Main Actor')" />
                        <select name="mainActor" id="edit-mainActor" class="block mt-1 w-full">
                            <option value="">{{ __('Select an actor') }}</option>
                            @foreach ($actors as $actor)
                                <option value="{{ $actor->ActorID }}">{{ $actor->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="edit-image" :value="__('Movie Image')" class="mt-4" />
                        <x-text-input id="edit-image" class="block mt-1 w-full" type="file" name="image" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="current-image" :value="__('Current Movie Image')" />
                        <img id="current-image" src="" alt="Current Image" width="200" height="250">
                    </div>

                    <div class="modal-footer">
                        <x-primary-button class="ms-4" type="submit">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
