@extends('layouts.app')

@section('title', 'Torneo de Eliminación - Resultados')

@section('content')
    <div class="container">
        <h1 class="text-center">Torneo de Eliminación - Resultados</h1>

        <a href="{{ route('tournaments.generate') }}" class="btn btn-success">Nuevo Torneo</a>

        @foreach($gamesByRound as $round => $games)
            <div class="round round-{{ $round }}">
                <h3 class="text-center">Ronda {{ $round }}</h3>
                <table class="table table-bordered table-hover table-equal-width">
                    <thead>
                    <tr>
                        <th>Equipo Local</th>
                        <th>Equipo Visitante</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($games as $game)
                        <tr>
                            <td class="{{ $game->team_local_score > $game->team_visitor_score ? 'winner' : 'loser' }}">
                                {{ $game->teamLocal->name }} ({{ $game->team_local_score }})
                            </td>
                            <td class="{{ $game->team_visitor_score > $game->team_local_score ? 'winner' : 'loser' }}">
                                {{ $game->teamVisitor->name }} ({{ $game->team_visitor_score }})
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No hay juegos para la Ronda {{ $round }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach

        <div class="finals mt-5">
            <h2 class="text-center">Partidos Finales</h2>

            <div class="mt-3">
                <h3 class="text-center">Tercer Puesto</h3>
                @if(isset($thirdPlaceGame))
                    <table class="table table-bordered table-hover table-equal-width">
                        <thead>
                        <tr>
                            <th>Equipo Local</th>
                            <th>Equipo Visitante</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="{{ $thirdPlaceGame->team_local_score > $thirdPlaceGame->team_visitor_score ? 'winner' : 'loser' }}">
                                {{ $thirdPlaceGame->teamLocal->name }} ({{ $thirdPlaceGame->team_local_score }})
                            </td>
                            <td class="{{ $thirdPlaceGame->team_visitor_score > $thirdPlaceGame->team_local_score ? 'winner' : 'loser' }}">
                                {{ $thirdPlaceGame->teamVisitor->name }} ({{ $thirdPlaceGame->team_visitor_score }})
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <p>No se ha jugado el partido por el tercer puesto aún.</p>
                @endif
            </div>

            <div class="mt-3">
                <h3 class="text-center">Final</h3>
                @if(isset($finalGame))
                    <table class="table table-bordered table-hover table-equal-width">
                        <thead>
                        <tr>
                            <th>Equipo Local</th>
                            <th>Equipo Visitante</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="{{ $finalGame->team_local_score > $finalGame->team_visitor_score ? 'winner' : 'loser' }}">
                                {{ $finalGame->teamLocal->name }} ({{ $finalGame->team_local_score }})
                            </td>
                            <td class="{{ $finalGame->team_visitor_score > $finalGame->team_local_score ? 'winner' : 'loser' }}">
                                {{ $finalGame->teamVisitor->name }} ({{ $finalGame->team_visitor_score }})
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <p>No se ha jugado la final aún.</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        .winner {
            background-color: #d4edda;
            font-weight: bold;
            color: #155724;
        }

        .loser {
            background-color: #f8d7da;
            color: #721c24;
        }

        .table {
            margin-top: 20px;
        }

        .table-equal-width th, .table-equal-width td {
            width: 50%;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        h3 {
            margin-top: 20px;
        }
    </style>
@endsection
