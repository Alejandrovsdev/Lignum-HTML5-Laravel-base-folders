@extends('admin-dashboard')

@section('header')
    <i class="fa-solid fa-video"></i>
    {{ __('Movies') }}
@endsection

@section('content')
    @livewire('movies.list-movies')
    @livewire('movies.create-movie')
    @livewire('movies.delete-movie')
@endsection

@section('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swalConfirmMsg', () => {
                swalConfirmMsg();
            })
            Livewire.on('swalErrorMsg', (response) => {
                swalErrorMsg(response.response.general);
            })
        })
    </script>
@endsection
