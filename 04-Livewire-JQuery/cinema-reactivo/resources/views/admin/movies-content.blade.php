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
    <script src=" {{ asset('js/movies-content-scripts.js') }} "></script>
@endsection
