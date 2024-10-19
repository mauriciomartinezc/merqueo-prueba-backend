@extends('layouts.app')

@section('title', 'Lista de Jugadores')

@section('content')
    <div class="container">
        <h1>Listado de Jugadores</h1>
        <a href="{{ route('players.create') }}" class="btn btn-primary">Crear Jugador</a>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if($players->count())
            <table class="table mt-3">
                <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Equipo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>
                            @if($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" alt="Foto" width="50">
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->team->name }}</td>
                        <td>
                            <a href="{{ route('players.show', $player->id) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $players->links() }}
            </div>
        @else
            <p>No hay jugadores disponibles.</p>
        @endif
    </div>
@endsection
