<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cinema</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h2 class="text-xl text-white font-semibold text-center mb-5">Cinema Movies</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            @foreach ($movies as $movie)
                <div
                    class="flex flex-col justify-center items-center bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ asset($movie->image) }}" alt="Movie image" class="w-full h-60 object-cover">
                    <h3 class="my-3 text-white font-semibold text-center">{{ $movie->title }}</h3>
                    <button class="bg-yellow-400 font-bold rounded-md py-1 px-4 mb-4 btn-add-to-favorites"
                        data-movie-id="{{ $movie->movie_id }}" data-is-favorite-status="{{ $movie->is_favorite }}">
                        @if ($movie->is_favorite == 0)
                            Add to favorites
                        @else
                            Remove from favorites
                        @endif
                    </button>
                </div>
            @endforeach
        </div>

        <h2 class="text-xl text-white font-semibold text-center mb-5">My favorites movies</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 favorites-movie-container">
        </div>
    </div>
    <script>
        // Función para agregar a favoritos
        function addMovieToFavorites(button) {
            const movie = button.data('movie-id');

            $.ajax({
                type: 'POST',
                url: `/user/add-to-favorites/${movie}`,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.is_favorite === 1) {
                        button.text('Remove from favorites');
                        button.data('is-favorite-status', 1);
                        refreshFavoritesMovies();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function removeMovieFromFavorites(button) {
            const movie = button.data('movie-id');

            $.ajax({
                type: 'POST',
                url: `/user/remove-from-favorites/${movie}`,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.is_favorite === 0) {
                        button.text('Add to favorites');
                        button.data('is-favorite-status', 0);
                        refreshFavoritesMovies();
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function showFavoritesMovies(movies) {
            $('.favorites-movie-container').empty();

            $.each(movies, function(index, movie) {
                var html =
                    '<div class="flex flex-col justify-center items-center bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">';
                html += '<img src="' + movie.image + '" alt="Movie image" class="w-full h-60 object-cover">';
                html += '<h3 class="my-3 text-white font-semibold text-center">' + movie.title + '</h3>';
                html += '</div>';

                $('.favorites-movie-container').append(html);
            });
        }

        function refreshFavoritesMovies() {
            $.ajax({
                url: '/user/show-favorites-movies',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    showFavoritesMovies(response.favorites_movies);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $(document).ready(function() {
            $('.btn-add-to-favorites').on('click', function() {
                const button = $(this);
                const isFavorite = button.data('is-favorite-status');

                if (isFavorite == 1) {
                    removeMovieFromFavorites(button);
                } else {
                    addMovieToFavorites(button);
                }
            });

            refreshFavoritesMovies();
        });
    </script>
</body>
