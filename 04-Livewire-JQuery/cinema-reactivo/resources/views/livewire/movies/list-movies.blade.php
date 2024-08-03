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
                        <th scope="col">Duration (min)</th>
                        <th scope="col">Main Actor</th>
                        <th scope="col">Image</th>
                        <th scope="col">Actions</th>
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
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <x-secondary-button class="me-3 edit-movie-button"
                                        data-id="{{ $movie->MovieID }}">edit</x-secondary-button>
                                    <x-danger-button data-bs-toggle="modal" data-bs-target="#deleteMovieModal"
                                        wire:click="$dispatch('openDeleteMovieModal', { movieId: {{ $movie->MovieID }} })">X</x-danger-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $movies->links() }}

        </div>
    </div>
    @livewire('movies.create-movies')
    @include('components.edit-movie-modal')
    @livewire('movies.delete-movies')

    <script>
        document.addEventListener('livewire:init', function() {
            $(document).off('click', '.edit-movie-button');

            $(document).on('click', '.edit-movie-button', function() {
                var movieId = $(this).data('id');
                var modal = $('#editMovieModal');
                modal.modal('show');

                $.ajax({
                    url: '/admin/movies/edit/' + movieId,
                    method: 'GET',
                    success: function(data) {
                        $('#edit-movie-id').val(data.movie.MovieID);
                        $('#edit-title').val(data.movie.Title);
                        $('#edit-duration').val(data.movie.Duration);
                        $('#edit-synopsis').val(data.movie.Synopsis);
                        $('#edit-mainActor').val(data.movie.PrincipalActorID);
                        $('#current-image').attr('src', data.movie.Image);
                    }
                });
            });

            $(document).on('submit', '#edit-movie-form', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var movieId = $('#edit-movie-id').val();

                $.ajax({
                    url: '/admin/movies/' + movieId,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        $('#editMovieModal').modal('hide');
                        updateTable(response.movie);
                    },
                    error: function(response) {
                        alert('An error occurred while updating the movie.');
                    }
                });
            });

            function updateTable(movie) {
                var row = $('#movie-' + movie.MovieID);
                row.find('.title').text(movie.Title);
                row.find('.duration').text(movie.Duration);
                row.find('.main-actor').text(movie.nameActor);
                var image = row.find('.movie-image');
                if (movie.Image) {
                    image.attr('src', movie.Image);
                }
            }
        });
    </script>
</div>
