@extends('layouts.app')

@section('title', isset($player) ? 'Editar Jugador' : 'Crear Jugador')

@section('content')
    <div class="container">
        <h1>{{ isset($player) ? 'Editar Jugador' : 'Crear Jugador' }}</h1>

        <a href="{{ route('players.index') }}" class="btn btn-warning mb-3">Volver</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($player) ? route('players.update', $player->id) : route('players.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($player))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Nombre *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $player->name ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="age">Edad *</label>
                <input type="number" name="age" class="form-control" value="{{ old('age', $player->age ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="nationality">Nacionalidad *</label>
                <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $player->nationality ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="team_id">Equipo *</label>
                <select name="team_id" class="form-control" required>
                    <option value="">Selecciona un equipo</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id', $player->team_id ?? '') === $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="position">Posición *</label>
                <input type="text" name="position" class="form-control" value="{{ old('position', $player->position ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="shirt_number">Número de la camiseta *</label>
                <input type="number" name="shirt_number" class="form-control" value="{{ old('shirt_number', $player->shirt_number ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="photo">Foto *</label>
                <input type="file" name="photo" class="form-control">
                @if(isset($player) && $player->photo)
                    <img src="{{ asset('storage/' . $player->photo) }}" alt="Foto" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ isset($player) ? 'Actualizar' : 'Crear' }}</button>
        </form>
    </div>
@endsection
