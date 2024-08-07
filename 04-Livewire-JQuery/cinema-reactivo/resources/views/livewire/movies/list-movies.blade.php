<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center leading-tight">
            {{ __('Movies CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createMovieModal">Create Movie</x-primary-button>

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
                        <th scope="col">Title</th>
                        <th scope="col">Duration (min)</th>
                        <th scope="col">Main Actor</th>
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
                            <td><img src="{{ asset($movie->Image) }}" class="movie-image" alt="movie image"
                                    width="100" height="150">
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="me-3 edit-movie-button text-2xl"
                                        data-id="{{ $movie->MovieID }}"><i
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
