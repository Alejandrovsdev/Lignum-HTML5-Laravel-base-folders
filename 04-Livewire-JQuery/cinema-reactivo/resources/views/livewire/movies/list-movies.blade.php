<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center leading-tight">
            {{ __('Movies CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="mb-3" data-bs-toggle="modal" data-bs-target="#createMovieModal">Create
            Movie</x-primary-button>

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
                        if (response.errors) {
                            const responseMsg = response.errors;
                            Livewire.dispatch('swalErrorMsg', { response: responseMsg });
                        } else {
                            $('#editMovieModal').modal('hide');
                            Livewire.dispatch('swalConfirmMsg');
                            updateTable(response.movie);
                        }
                    },
                    error: function(response) {
                        const responseMsg = response.errors;
                        Livewire.dispatch('swalErrorMsg', { response: responseMsg });
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
