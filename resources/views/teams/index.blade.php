@extends('layouts.app')

@section('title', 'Lista de Equipos')

@section('content')
    <div class="container">
        <h1>Lista de Equipos</h1>
        <a href="{{ route('teams.create') }}" class="btn btn-primary">Crear Equipo</a>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if($teams->count())
            <table class="table mt-3">
                <thead>
                <tr>
                    <th>Bandera</th>
                    <th>Nombre</th>
                    <th>País</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>
                            @if($team->flag_image)
                                <img src="{{ asset('storage/' . $team->flag_image) }}" alt="Bandera" width="50">
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->country->name }}</td>
                        <td>
                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
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
                {{ $teams->links() }}
            </div>
        @else
            <p>No hay equipos disponibles.</p>
        @endif
    </div>
@endsection
