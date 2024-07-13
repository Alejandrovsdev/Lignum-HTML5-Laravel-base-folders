<x-guest-layout>
    <h2 class=" text-gray-50">Title</h2>
    <p class=" text-gray-400">{{ $movie->title }}</p>
    <h2 class=" text-gray-50">Main Actor</h2>
    <p class=" text-gray-400">{{ $movie->principalActor->name }}</p>
    <h2 class=" text-gray-50">Duration</h2>
    <p class=" text-gray-400">{{ $movie->duration }}</p>
    <h2 class=" text-gray-50">Year</h2>
    <p class=" text-gray-400">{{ $movie->year }}</p>
    <h2 class=" text-gray-50">Synopsis</h2>
    <p class=" text-gray-400">{{ $movie->synopsis }}</p>
    <h2 class=" text-gray-50">Image</h2>
    <img src="{{ asset($movie->image) }}" alt="Movie image" width="300" height="600">
</x-guest-layout>
