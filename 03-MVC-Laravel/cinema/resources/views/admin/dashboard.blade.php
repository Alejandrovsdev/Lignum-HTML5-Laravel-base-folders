<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class= "dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center text-xl">Actors</th>
                        </tr>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Birthdate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actors as $actor)
                            <tr>
                                <th scope="row">{{ $actor->actor_id }}</th>
                                <td>{{ $actor->name }}</td>
                                <td>{{ $actor->birthdate }}</td>
                            </tr>
                        @empty
                            <td colspan="3" class="text-center">There's not actors register</td>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class= "dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th colspan="5" class="text-center text-xl">Movies</th>
                        </tr>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Year</th>
                            <th scope="col">Main Actor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movies as $movie)
                            <tr>
                                <th scope="row">{{ $movie->movie_id }}</th>
                                <td>{{ $movie->title }}</td>
                                <td>{{ $movie->duration }}</td>
                                <td>{{ $movie->year }}</td>
                                <td>{{ $movie->principalActor->name }}</td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">There's not actors register</td>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class= "dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{ $movies->links('pagination::Bootstrap-5') }}
            </div>


        </div>
    </div>
</x-app-layout>
