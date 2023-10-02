@extends('layouts.welcome')

@section('title', 'Bienvenido!')

@section('content')

    <h1 class="cover-heading text-white">Bienvenido!</h1>
    <p class="lead text-white">¿Quieres averiguar que tipo de usuario eres en gamificación?</p>
    <p class="lead">
        <a href="{{ route('home.people') }}" class="btn btn-lg btn-danger" title="Click aqui para comenzar">
            <i class="fa fa-gamepad" aria-hidden="true"></i>
        </a>
    </p>

@endsection
