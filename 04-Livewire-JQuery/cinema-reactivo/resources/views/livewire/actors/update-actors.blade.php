<div class="modal fade" id="updateActorModal" tabindex="-1" aria-labelledby="updateActorModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateActorModalLabel">Update Actor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateActor">
                    <div>
                        <x-input-label for="name" :value="__('Actor Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" wire:model="name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="birthdate" :value="__('Actor Birthdate')" />
                        <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" wire:model="birthdate" required />
                        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
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
