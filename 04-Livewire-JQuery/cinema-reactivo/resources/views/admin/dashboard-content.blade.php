@extends('admin-dashboard')

@section('header')
    <i class="fa-solid fa-table"></i>
    {{ __('Dashboard') }}
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg mb-5 text-gray-800">
            <table class="table border-gray-800 text-gray-800">
                <thead>
                    <tr class="bg-gray-400">
                        <th colspan="3" class="text-center text-xl text-white">Actors</th>
                    </tr>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Birthdate</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($actors->count() == 0)
                        <td colspan="5" class="text-center">There's not actors register</td>
                    @endif
                    @foreach ($actors as $actor)
                        <tr>
                            <th scope="row">{{ $actor->ActorID }}</th>
                            <td>{{ $actor->Name }}</td>
                            <td>{{ $actor->Birthdate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden shadow-sm sm:rounded-lg text-gray-800">
            <table class="table border-gray-800 text-gray-800">
                <thead>
                    <tr class="bg-gray-400">
                        <th colspan="5" class="text-center text-xl text-white">Movies</th>
                    </tr>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Duration (min)</th>
                        <th scope="col">Main Actor</th>
                        <th scope="col">Image</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($movies->count() == 0)
                    <td colspan="6" class="text-center">There's not movies register</td>
                @endif
                @foreach ($movies as $movie)
                    <tr id="movie-{{ $movie->MovieID }}">
                        <th scope="row">{{ $movie->MovieID }}</th>
                        <td>{{ $movie->Title }}</td>
                        <td>{{ $movie->Duration }}</td>
                        <td>
                            {{ $movie->mainActor->Name ?? $movie->mainActor()->withTrashed()->first()->Name }}</td>
                        <td><img src="{{ asset($movie->Image) }}" class="movie-image" alt="movie image"
                                width="100" height="150">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class= "overflow-hidden shadow-sm sm:rounded-lg">
            {{ $movies->links() }}
        </div>


    </div>
@endsection
