<div class="modal fade" id="createActorModal" tabindex="-1" aria-labelledby="createActorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="createActorModalLabel">Create Actor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="createActorForm" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Actor Name')" />
                        <x-text-input type="text" name="name" id="name" class="block mt-1 w-full" :value="old('name')" autofocus autocomplete="name" />
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="birthdate" :value="__('Actor Birthdate')" />
                        <x-text-input type="date" name="birthdate" id="birthdate" class="block mt-1 w-full" />
                        @error('birthdate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="country" :value="__('Country')" />
                        <select name="country" id="country" class="block mt-1 w-full">
                            <option value="">{{ __('Select a Country') }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->CountryID }}">{{ $country->CountryName }}</option>
                            @endforeach
                        </select>
                        @error('actorCountry')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <x-primary-button class="ms-4" type="submit">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
