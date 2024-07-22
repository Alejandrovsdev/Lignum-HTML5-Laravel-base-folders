<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center leading-tight">
            {{ __('Actors CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createActorModal">Create
            Actor</x-primary-button>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="overflow-hidden shadow-sm sm:rounded-lg text-gray-800">
            <table class="table border-gray-800 text-gray-800">
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
                                    <x-secondary-button class="me-3" data-bs-toggle="modal"
                                        data-bs-target="#updateActorModal"
                                        wire:click="$dispatch('openUpdateActorModal', { actorId: {{ $actor->ActorID }} })">edit</x-secondary-button>
                                    <x-danger-button data-bs-toggle="modal" data-bs-target="#deleteActorModal"
                                        wire:click="$dispatch('openDeleteActorModal', { actorId: {{ $actor->ActorID }} })">X</x-danger-button>
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
