<div class="py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actors CRUD') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-primary-button class="bg-green-600 mb-3">Create Actor</x-primary-button>
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
                    @forelse ($actores as $actor)
                        <tr>
                            <th scope="row">{{ $actor->actor_id }}</th>
                            <td>{{ $actor->name }}</td>
                            <td>{{ $actor->birthdate }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <a class="me-3" href="">
                                        <x-secondary-button>Edit</x-secondary-button>
                                    </a>
                                    <form method="POST" action="">
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
                        <td colspan="5" class="text-center">There's not actors register</td>
                    @endforelse
                </tbody>
            </table>
            {{ $actores->links() }}

        </div>
    </div>
</div>
