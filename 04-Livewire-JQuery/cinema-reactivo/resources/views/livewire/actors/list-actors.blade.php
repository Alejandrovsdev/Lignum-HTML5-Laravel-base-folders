<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actors CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="bg-green-600 mb-3" data-bs-toggle="modal" data-bs-target="#createActorModal">Create Actor</x-primary-button>

        <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
            <table class="table text-white">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Birthdate</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actores as $actor)
                        <tr>
                            <th scope="row">{{ $actor->ActorID }}</th>
                            <td>{{ $actor->Name }}</td>
                            <td>{{ $actor->Birthdate }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <x-alert-button class="me-3" data-bs-toggle="modal" data-bs-target="#updateActorModal" wire:click="$dispatch('openUpdateActorModal', { actorId: {{ $actor->ActorID }} })">edit</x-alert-button>
                                    <x-danger-button data-bs-toggle="modal" data-bs-target="#deleteActorModal" wire:click="$dispatch('openDeleteActorModal', { actorId: {{ $actor->ActorID }} })">X</x-danger-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="5" class="text-center">There's not actors register</td>
                    @endforelse
                </tbody>
            </table>
            {{ $actores->links() }}

        </div>
    </div>
    @livewire('actors.create-actors')
    @livewire('actors.update-actors')
    @livewire('actors.delete-actors')
</div>

