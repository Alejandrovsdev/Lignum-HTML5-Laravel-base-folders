<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center leading-tight">
            {{ __('Movies CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createMovieModal">Create
            Movie</x-primary-button>

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
                        <th scope="col">Title</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Main Actor</th>
                        <th scope="col">Image</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movies as $movie)
                        <tr>
                            <th scope="row">{{ $movie->MovieID }}</th>
                            <td>{{ $movie->Title }}</td>
                            <td>{{ $movie->Duration }}</td>
                            <td>{{ $movie->mainActor->Name }}</td>
                            <td><img src="{{ asset($movie->image) }}" alt="movie image" width="100" height="150"></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <x-secondary-button class="me-3" data-bs-toggle="modal"
                                        data-bs-target="#updateMovieModal"
                                        wire:click="$dispatch('openUpdateMovieModal', { movieId: {{ $movie->MovieID }} })">edit</x-secondary-button>
                                    <x-danger-button data-bs-toggle="modal" data-bs-target="#deleteMovieModal"
                                        wire:click="$dispatch('openDeleteMovieModal', { movieId: {{ $movie->MovieID }} })">X</x-danger-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td colspan="5" class="text-center">There's not movies register</td>
                    @endforelse
                </tbody>
            </table>
            {{ $movies->links() }}

        </div>
    </div>
    @livewire('movies.create-movies')
    @livewire('movies.update-movies')
    @livewire('movies.delete-movies')
</div>
