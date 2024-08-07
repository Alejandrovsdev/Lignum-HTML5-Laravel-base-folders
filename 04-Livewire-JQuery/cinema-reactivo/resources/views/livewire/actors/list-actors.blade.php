<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createActorModal">Create
            Actor</x-primary-button>

        <div class="text-xl">
            <button class="hover:text-green-800" onclick="toggleIcons()">
                <i class="fa-solid fa-filter"></i>
                <soan>filters</soan>
            </button>
            <div id="icons" class="hidden icons-container flex justify-between">
                <div class="searchInputContainer">
                    <x-input-label for="search" />
                    <button class="hover:text-green-600 text-end">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <x-text-input id="search" type="text" />
                </div>

                <div class="orderIconsContainer">
                    <button class="hover:text-green-600 me-3">
                        <i class="fa-solid fa-arrow-up-1-9"></i>
                    </button>

                    <button class="hover:text-green-600 me-3">
                        <i class="fa-solid fa-arrow-down-9-1"></i>
                    </button>

                    <button class="hover:text-green-600 me-3">
                        <i class="fa-solid fa-arrow-down-z-a"></i>
                    </button>

                    <button class="hover:text-green-600 me-3">
                        <i class="fa-solid fa-arrow-up-a-z"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-hidden shadow-sm sm:rounded-lg text-gray-800">
            <table class="table border-gray-800 text-gray-800">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Birthdate</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($actores->count() == 0)
                        <td colspan="5" class="text-center">There's not actors register</td>
                    @endif
                    @foreach ($actores as $actor)
                        <tr>
                            <th scope="row">{{ $actor->ActorID }}</th>
                            <td>{{ $actor->Name }}</td>
                            <td>{{ $actor->Birthdate }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="me-3 text-2xl" data-bs-toggle="modal"
                                        data-bs-target="#updateActorModal"
                                        wire:click="$dispatch('openUpdateActorModal', { actorId: {{ $actor->ActorID }} })"><i
                                            class="fa-regular fa-pen-to-square text-blue-600"></i></button>
                                    <button class="text-2xl" data-bs-toggle="modal" data-bs-target="#deleteActorModal"
                                        wire:click="$dispatch('openDeleteActorModal', { actorId: {{ $actor->ActorID }} })"><i
                                            class="fa-solid fa-trash text-red-600 text-md"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $actores->links() }}
        </div>
    </div>
</div>
