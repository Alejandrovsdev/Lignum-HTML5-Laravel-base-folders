<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center leading-tight">
            {{ __('Movies CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createMovieModal">Create
            Movie</x-primary-button>

        <div class="text-xl mb-3">
            <button class="hover:text-green-800 mb-3" onclick="toggleIcons()">
                <i class="fa-solid fa-filter"></i>
                <span>filters</span>
            </button>
            <div wire:ignore.self id="icons" class="hidden icons-container flex justify-between">
                <div class="searchInputContainer">
                    <x-input-label for="search" />
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <x-text-input wire:model.live="search" class="h-8" id="search" type="search" />
                </div>
            </div>
        </div>

        <div class="overflow-hidden shadow-sm sm:rounded-lg text-gray-800">
            <table class="table border-gray-800 text-gray-800">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="flex items-center">
                                <button wire:click="sortBy('MovieID')" class="me-2">#Id</button>
                                @if ($sortField !== 'MovieID')
                                    <span></span>
                                @elseif ($sortAsc)
                                    <span>
                                        <i class="fa-solid fa-arrow-up-1-9"></i>
                                    </span>
                                @else
                                    <span>
                                        <i class="fa-solid fa-arrow-down-9-1"></i>
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col">
                            <div class="flex items-center">
                                <button wire:click="sortBy('Title')" class="me-2">Title</button>
                                @if ($sortField !== 'Title')
                                    <span></span>
                                @elseif ($sortAsc)
                                    <span>
                                        <i class="fa-solid fa-arrow-up-a-z"></i>
                                    </span>
                                @else
                                    <span>
                                        <i class="fa-solid fa-arrow-down-z-a"></i>
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col">
                            <div class="flex items-center">
                                <button wire:click="sortBy('Duration')" class="me-2">Duration (min)</button>
                                @if ($sortField !== 'Duration')
                                    <span></span>
                                @elseif ($sortAsc)
                                    <span>
                                        <i class="fa-solid fa-arrow-up-1-9"></i>
                                    </span>
                                @else
                                    <span>
                                        <i class="fa-solid fa-arrow-down-9-1"></i>
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col">
                            <div class="flex items-center">
                                <button wire:click="sortBy('mainActor.Name')" class="me-2">Main Actor</button>
                                @if ($sortField !== 'mainActor.Name')
                                    <span></span>
                                @elseif ($sortAsc)
                                    <span>
                                        <i class="fa-solid fa-arrow-up-a-z"></i>
                                    </span>
                                @else
                                    <span>
                                        <i class="fa-solid fa-arrow-down-z-a"></i>
                                    </span>
                                @endif
                            </div>
                        </th>
                        <th scope="col">Image</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($movies->count() == 0)
                        <td colspan="6" class="text-center">There's not movies register</td>
                    @endif
                    @foreach ($movies as $movie)
                        <tr id="movie-{{ $movie->MovieID }}">
                            <th scope="row">{{ $movie->MovieID }}</th>
                            <td class="title">{{ $movie->Title }}</td>
                            <td class="duration">{{ $movie->Duration }}</td>
                            <td class="main-actor">
                                {{ $movie->mainActor->Name ?? $movie->mainActor()->withTrashed()->first()->Name }}</td>
                            {{-- en caso de relaciones anidadas agregar ? --}}
                            <td><img src="{{ asset($movie->Image) }}" class="movie-image" alt="movie image"
                                    width="100" height="150">
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="me-3 edit-movie-button text-2xl" data-id="{{ $movie->MovieID }}"><i
                                            class="fa-regular fa-pen-to-square text-blue-600"></i></button>
                                    <button class="text-2xl" data-bs-toggle="modal" data-bs-target="#deleteMovieModal"
                                        wire:click="$dispatch('openDeleteMovieModal', { movieId: {{ $movie->MovieID }} })"><i
                                            class="fa-solid fa-trash text-red-600 text-md"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $movies->links() }}
        </div>
        @include('components.edit-movie-modal')
    </div>
</div>
