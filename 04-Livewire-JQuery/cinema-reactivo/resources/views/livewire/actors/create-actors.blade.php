<div wire:ignore.self class="modal fade" id="createActorModal" tabindex="-1" aria-labelledby="createActorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="createActorModalLabel">Create Actor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="createActor">
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
                        <x-primary-button class="ms-4" type="submit" data-bs-dismiss="modal">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
