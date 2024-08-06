<div wire:ignore.self class="modal fade" id="updateActorModal" tabindex="-1" aria-labelledby="updateActorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray-500">
                <h5 class="modal-title text-white" id="updateActorModalLabel">Update Actor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="updateActor">
                    <div>
                        <x-input-label for="name" :value="__('Actor Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" wire:model.blur="name" autofocus autocomplete="name" />
                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="birthdate" :value="__('Actor Birthdate')" />
                        <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" wire:model.blur="birthdate" />
                        @error('birthdate') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer">
                        <x-secondary-button class="ms-4" type="submit" data-bs-dismiss="modal">
                            {{ __('Update') }}
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
