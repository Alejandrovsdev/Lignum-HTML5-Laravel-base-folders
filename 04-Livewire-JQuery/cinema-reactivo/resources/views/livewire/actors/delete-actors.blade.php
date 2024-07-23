<div class="modal fade" id="deleteActorModal" tabindex="-1" aria-labelledby="deleteActorModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteActorModalLabel">Delete Actor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>Are u sure about that???</h2>
            </div>
            <div class="modal-footer">
                <x-secondary-button class="ms-4" data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ms-4" wire:click="deleteActor" type="submit" data-bs-dismiss="modal">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </div>
    </div>
</div>
