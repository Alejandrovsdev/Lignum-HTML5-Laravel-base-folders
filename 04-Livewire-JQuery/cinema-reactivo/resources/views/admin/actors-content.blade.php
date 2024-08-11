@extends('admin-dashboard')

@section('header')
    <i class="fa-solid fa-user"></i>
    {{ __('Actors') }}
@endsection

@section('content')
    @livewire('actors.list-actors')
    @livewire('actors.create-actor')
    @livewire('actors.update-actor')
    @livewire('actors.delete-actor')
@endsection

@section('scripts')
    <script src="{{ asset('js/actors-content-scripts.js') }}"></script>
@endsection
