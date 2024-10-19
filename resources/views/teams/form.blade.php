@extends('layouts.app')

@section('title', isset($team) ? 'Editar Equipo' : 'Crear Equipo')

@section('content')
    <div class="container">
        <h1>{{ isset($team) ? 'Editar Equipo' : 'Crear Equipo' }}</h1>

        <a href="{{ route('teams.index') }}" class="btn btn-warning mb-3">Volver</a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($team) ? route('teams.update', $team->id) : route('teams.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($team))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Nombre *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $team->name ?? '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="country_id">País</label>
                <select name="country_id" class="form-control" required>
                    <option value="">Selecciona un país</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country', $team->country_id ?? '') === $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="flag_image">Imagen de la Bandera *</label>
                <input type="file" name="flag_image" class="form-control">
                @if(isset($team) && $team->flag_image)
                    <img src="{{ asset('storage/' . $team->flag_image) }}" alt="Bandera" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ isset($team) ? 'Actualizar' : 'Crear' }}</button>
        </form>
    </div>
@endsection
