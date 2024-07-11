<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Actors Crud') }}
        </h2>
        <a href="{{ route('admin-actors-create') }}"><x-primary-button>Create
                Actor</x-primary-button></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-white">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Birthdate</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actors as $actor)
                            <tr>
                                <th scope="row">{{ $actor->actor_id }}</th>
                                <td>{{ $actor->name }}</td>
                                <td>{{ $actor->birthdate }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <a href="{{ route('admin-actors-edit', ['actor' => $actor->actor_id]) }}">
                                            <x-secondary-button>Edit</x-secondary-button>
                                        </a>
                                        <form method="POST"
                                            action="{{ route('admin-actors-delete', ['actor' => $actor->actor_id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <a href="">
                                                <x-danger-button>Delete</x-danger-button>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <p>There's not actors register</p>
                        @endforelse
                    </tbody>
                </table>

                {{ $actors->links('pagination::Bootstrap-5') }}

            </div>
        </div>
    </div>
</x-app-layout>
