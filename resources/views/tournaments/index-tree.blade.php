@extends('layouts.app')

@section('title', 'Torneo de Eliminación - Resultados')

@section('content')
    <div class="container">
        <h1 class="text-center">Torneo de Eliminación - Vista en Árbol</h1>

        <a href="{{ route('tournaments.generate') }}" class="btn btn-success">Nuevo Torneo</a>

        <div class="tournament-bracket">
            @foreach($gamesByRound as $round => $games)
                <div class="round round-{{ $round }}">
                    <h3 class="text-center">Ronda {{ $round }}</h3>
                    <div class="matches">
                        @forelse($games as $game)
                            <div class="match">
                                <div
                                    class="team {{ $game->team_local_score > $game->team_visitor_score ? 'winner' : 'loser' }}">
                                    <img src="{{ asset('storage/' . $game->teamLocal->flag_image) }}"
                                         alt="Escudo de {{ $game->teamLocal->name }}" class="team-logo">
                                    {{ $game->teamLocal->name }} ({{ $game->team_local_score }})
                                </div>
                                <div class="vs">VS</div>
                                <div
                                    class="team {{ $game->team_visitor_score > $game->team_local_score ? 'winner' : 'loser' }}">
                                    <img src="{{ asset('storage/' . $game->teamVisitor->flag_image) }}"
                                         alt="Escudo de {{ $game->teamVisitor->name }}" class="team-logo">
                                    {{ $game->teamVisitor->name }} ({{ $game->team_visitor_score }})
                                </div>
                            </div>
                        @empty
                            <p>No hay juegos para la Ronda {{ $round }}</p>
                        @endforelse
                    </div>
                </div>
            @endforeach

            <div class="finals mt-5">
                <h2 class="text-center">Partidos Finales</h2>
                <div class="mt-3">
                    <h3 class="text-center">Tercer Puesto</h3>
                    @if(isset($thirdPlaceGame))
                        <div class="match">
                            <div
                                class="team {{ $thirdPlaceGame->team_local_score > $thirdPlaceGame->team_visitor_score ? 'winner' : 'loser' }}">
                                <img src="{{ asset('storage/' . $thirdPlaceGame->teamLocal->flag_image) }}"
                                     alt="Escudo de {{ $thirdPlaceGame->teamLocal->name }}" class="team-logo">
                                {{ $thirdPlaceGame->teamLocal->name }} ({{ $thirdPlaceGame->team_local_score }})
                            </div>
                            <div class="vs">VS</div>
                            <div
                                class="team {{ $thirdPlaceGame->team_visitor_score > $thirdPlaceGame->team_local_score ? 'winner' : 'loser' }}">
                                <img src="{{ asset('storage/' . $thirdPlaceGame->teamVisitor->flag_image) }}"
                                     alt="Escudo de {{ $thirdPlaceGame->teamVisitor->name }}" class="team-logo">
                                {{ $thirdPlaceGame->teamVisitor->name }} ({{ $thirdPlaceGame->team_visitor_score }})
                            </div>
                        </div>
                    @else
                        <p>No se ha jugado el partido por el tercer puesto aún.</p>
                    @endif
                </div>

                <div class="mt-3">
                    <h3 class="text-center">Final</h3>
                    @if(isset($finalGame))
                        <div class="match">
                            <div
                                class="team {{ $finalGame->team_local_score > $finalGame->team_visitor_score ? 'winner' : 'loser' }}">
                                <img src="{{ asset('storage/' . $finalGame->teamLocal->flag_image) }}"
                                     alt="Escudo de {{ $finalGame->teamLocal->name }}" class="team-logo">
                                {{ $finalGame->teamLocal->name }} ({{ $finalGame->team_local_score }})
                            </div>
                            <div class="vs">VS</div>
                            <div
                                class="team {{ $finalGame->team_visitor_score > $finalGame->team_local_score ? 'winner' : 'loser' }}">
                                <img src="{{ asset('storage/' . $finalGame->teamVisitor->flag_image) }}"
                                     alt="Escudo de {{ $finalGame->teamVisitor->name }}" class="team-logo">
                                {{ $finalGame->teamVisitor->name }} ({{ $finalGame->team_visitor_score }})
                            </div>
                        </div>
                    @else
                        <p>No se ha jugado la final aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .tournament-bracket {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .round {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 30%;
        }

        .matches {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .match {
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
        }

        .team {
            display: flex;
            align-items: center;
            padding: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .team.winner {
            background-color: #d4edda;
            border: 1px solid #28a745;
            border-radius: 4px;
        }

        .team.loser {
            background-color: #f8d7da;
            border: 1px solid #dc3545;
            border-radius: 4px;
        }

        .vs {
            margin: 0 10px;
            text-align: center;
            padding: 5px;
            font-weight: bold;
        }

        .team-logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .finals {
            margin-top: 50px;
            text-align: center;
        }
    </style>
@endsection
