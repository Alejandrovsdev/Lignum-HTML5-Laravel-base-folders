@extends('jq-practice-dashboard')

@section('header')
    <i class="fa-solid fa-table"></i>
    {{ __('JQ Crud') }}
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-primary-button class="mb-3" id="createMovieBtn">Create Movie</x-primary-button>
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-5 text-gray-800">
                <table class="table border-gray-800 text-gray-800">
                    <thead>
                        <tr class="bg-gray-400">
                            <th colspan="6" class="text-center text-xl text-white">Movies</th>
                        </tr>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Duration (min)</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Main Actor</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($movies->count() == 0)
                            <td colspan="6" class="text-center">There's not movies register</td>
                        @endif
                        @foreach ($movies as $movie)
                            <tr>
                                <th scope="row">{{ $movie->MovieID }}</th>
                                <td class="title">{{ $movie->Title }}</td>
                                <td class="duration">{{ $movie->Duration }}</td>
                                <td class="categories">{{ $movie->categories->pluck('CategoryName')->join(', ') }}</td>
                                <td class="main-actor">
                                    {{ $movie->mainActor->Name ?? $movie->mainActor()->withTrashed()->first()->Name }}</td>
                                {{-- en caso de relaciones anidadas agregar ? --}}
                                <td><img src="{{ asset($movie->Image) }}" class="movie-image" alt="movie image"
                                        width="100" height="150">
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button class="me-3 text-2xl" data-bs-toggle="modal"
                                            data-bs-target="#updateMovieModal">
                                            <i class="fa-regular fa-pen-to-square text-blue-600"></i>
                                        </button>
                                        <button class="text-2xl" data-bs-toggle="modal" data-bs-target="#deleteMovieModal">
                                            <i class="fa-solid fa-trash text-red-600 text-md"></i>
                                        </button>
                                    </div>
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
    @include('admin.jq-crud.create-jq-movie-modal')

    @section('scripts')
        <script src="{{ asset('js/jq-movies-content-scripts.js') }}"></script>
    @endsection
