<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($movies as $movie)
                <div class="flex flex-col justify-center items-center bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <img src="{{ asset($movie->image) }}" alt="Movie image" class="w-full h-60 object-cover">
                    <h3 class="my-3 text-white font-semibold text-center">{{ $movie->title }}</h3>
                    <button class="bg-yellow-400 font-bold rounded-md py-1 px-4 mb-4 btn-add-to-favorites" data-movie-id="{{$movie->id}}">Add to Favorites</button>
                </div>
            @endforeach
        </div>
    </div>
</body>
