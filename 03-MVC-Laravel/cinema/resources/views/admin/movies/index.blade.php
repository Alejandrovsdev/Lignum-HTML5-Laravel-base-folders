<x-app-layout>
    {{-- mostrar mensajes de confirmaciones --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Movies Crud') }}
        </h2>
        <a href="{{ route('admin-movies-create') }}"><x-primary-button>Create Movie</x-primary-button></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Year</th>
                            <th scope="col">Main Actor</th>
                            <th scope="col">Actions</th>
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
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <a href="" class="me-3"><x-secondary-button>Show</x-secondary-button></a>
                                        <a href="{{ route('admin-movies-edit', ['movie' => $movie->movie_id]) }}" class="me-3"><x-secondary-button>Edit</x-secondary-button></a>
                                        <form method="POST" action="{{ route('admin-movies-delete', ['movie' => $movie->movie_id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <a href=""><x-danger-button>Delete</x-danger-button></a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">There's not actors register</td>
                        @endforelse
                    </tbody>
                </table>

                {{ $movies->links('pagination::Bootstrap-5') }}

            </div>
        </div>
    </div>
</x-app-layout>

