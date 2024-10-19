@extends('layouts.app')

@section('title', "Equipo #$team->id")

@section('content')
    <div class="container">
        <h1>Detalles del Equipo</h1>

        <p><strong>Nombre:</strong> {{ $team->name }}</p>
        <p><strong>País:</strong> {{ $team->country->name }}</p>
        <p><strong>Bandera:</strong></p>
        @if($team->flag_image)
            <img src="{{ asset('storage/' . $team->flag_image) }}" alt="Bandera" width="100">
        @else
            <p>No disponible</p>
        @endif
        <div>
            <a href="{{ route('teams.index') }}" class="btn btn-primary mt-3">Volver</a>
        </div>
    </div>
@endsection
