@extends('layouts.app')

@section('title', "Jugador #$player->id")

@section('content')
    <div class="container">
        <h1>Detalles del Jugador</h1>

        <p><strong>Nombre:</strong> {{ $player->name }}</p>
        <p><strong>Edad:</strong> {{ $player->age }}</p>
        <p><strong>Nacionalidad:</strong> {{ $player->nationality }}</p>
        <p><strong>Equipo:</strong> {{ $player->team->name }}</p>
        <p><strong>Posición:</strong> {{ $player->position }}</p>
        <p><strong>Número de la camiseta:</strong> {{ $player->shirt_number }}</p>
        <p><strong>Foto:</strong></p>
        @if($player->photo)
            <img src="{{ asset('storage/' . $player->photo) }}" alt="Foto" width="100">
        @else
            <p>No disponible</p>
        @endif
        <div>
            <a href="{{ route('players.index') }}" class="btn btn-primary mt-3">Volver</a>
        </div>
    </div>
@endsection
