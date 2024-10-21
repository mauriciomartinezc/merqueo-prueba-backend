<?php

namespace App\Services\Game;

use App\Models\Game;
use Illuminate\Support\Collection as SupportCollection;

class GameService
{
    /**
     * Agrupar los juegos por rondas dinámicamente.
     *
     * @return SupportCollection
     */
    public function getGamesGroupedByRound(): SupportCollection
    {
        $games = Game::orderBy('date')->get();
        $teamsCount = $games->count();

        // Número de rondas basadas en log2 del número de equipos
        $totalRounds = (int) ceil(log($teamsCount * 2, 2)); // * 2 para reflejar el número de equipos, no juegos
        $gamesByRound = collect();

        $index = 0;
        for ($round = 1; $round < $totalRounds; $round++) {
            // Dividir progresivamente para obtener la cantidad de partidos
            $matchesInRound = (int) ($teamsCount / (2 ** $round));
            if ($matchesInRound > 0) {
                $gamesByRound[$round] = $games->slice($index, $matchesInRound);
                $index += $matchesInRound;
            }
        }

        return $gamesByRound;
    }

    /**
     * @return Game|null
     */
    public function getFinalGame(): ?Game
    {
        return Game::where('status', 'Finalizado')
            ->latest('id')
            ->first();
    }

    /**
     * @param Game|null $finalGame
     * @return Game|null
     */
    public function getThirdPlaceGame(?Game $finalGame): ?Game
    {
        return Game::where('status', 'Finalizado')
            ->where('team_local_score', '!=', 'team_visitor_score')
            ->whereNotIn('id', [$finalGame->id ?? 0])
            ->latest('id')
            ->first();
    }
}
