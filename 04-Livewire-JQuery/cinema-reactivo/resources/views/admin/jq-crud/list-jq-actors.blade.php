@extends('jq-practice-dashboard')

@section('header')
    <i class="fa-solid fa-table"></i>
    {{ __('JQ Crud') }}
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-primary-button class="mb-3" id="createActorBtn">Create Actor</x-primary-button>
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-5 text-gray-800">
                <table class="table border-gray-800 text-gray-800">
                    <thead>
                        <tr class="bg-gray-400">
                            <th colspan="5" class="text-center text-xl text-white">Actors</th>
                        </tr>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Birthdate</th>
                            <th scope="col">Country</th>
                            <th scope="col" class="text-center">Actions</th>

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
                                <td>{{ $actor->actorCountry->CountryName }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button class="me-3 text-2xl" data-bs-toggle="modal"
                                            data-bs-target="#updateActorModal">
                                            <i class="fa-regular fa-pen-to-square text-blue-600"></i>
                                        </button>
                                        <button class="text-2xl" data-bs-toggle="modal" data-bs-target="#deleteActorModal">
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
                {{ $actors->links() }}
            </div>
        </div>
    @endsection
    @include('admin.jq-crud.create-jq-actor-modal')

    @section('scripts')
        <script src="{{ asset('js/jq-actors-content-scripts.js') }}"></script>
    @endsection
