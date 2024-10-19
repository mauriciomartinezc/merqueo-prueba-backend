<?php

namespace App\Console\Commands;

use AllowDynamicProperties;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection as CollectionEloquent;
use Illuminate\Support\Collection as CollectionSupport;

#[AllowDynamicProperties] class SimulateGames extends Command
{
    /**
     * @var string
     */
    protected $signature = 'simulate:games';

    /**
     * @var string
     */
    protected $description = 'Simula un torneo eliminatorio y declara campeón, subcampeón y tercer puesto';

    /**
     * @return int
     */
    public function handle(): int
    {
        $teams = $this->getTeams();
        $teamsCount = $teams->count();

        if ($teamsCount % 2 !== 0) {
            $this->error('Para simular el torneo, el número de equipos debe ser un número par.');
            return 1;
        }

        if ($teams->count() < $teamsCount) {
            $this->error('No hay suficientes equipos para simular el torneo.');
            return 1;
        }

        Game::truncate();
        $this->playedGames = collect();
        $this->simulateTournament($teams);

        return 0;
    }

    /**
     * @return CollectionEloquent
     */
    private function getTeams(): CollectionEloquent
    {
        return Team::inRandomOrder()->get();
    }

    /**
     * @param CollectionEloquent $teams
     * @return void
     */
    private function simulateTournament(CollectionEloquent $teams): void
    {
        $roundNumber = 1;
        $currentTeams = $teams;

        while ($currentTeams->count() > 2) {
            $this->info("Ronda $roundNumber: Total de equipos: " . $currentTeams->count());
            $currentTeams = $this->simulateRound($currentTeams);
            $roundNumber++;
        }

        if ($currentTeams->count() === 2) {
            $this->simulateFinals($currentTeams);
        } else {
            $this->error('La final necesita exactamente 2 equipos. Solo quedaron ' . $currentTeams->count() . ' equipos.');
        }
    }

    /**
     * @param $teams
     * @return CollectionSupport
     */
    private function simulateRound($teams): CollectionSupport
    {
        $winners = collect();

        // Verificar si el número de equipos es impar
        if ($teams->count() % 2 !== 0) {
            $lastTeam = $teams->pop();
            $this->info("El equipo {$lastTeam->name} avanza automáticamente.");
            $winners->push($lastTeam);
        }

        $teams->chunk(2)->each(function ($pair) use ($winners) {
            if ($pair->count() === 2) {
                $localTeam = $pair->first();
                $visitorTeam = $pair->last();
                $winner = $this->simulateGame($localTeam, $visitorTeam);
                $winners->push($winner);
            }
        });

        return $winners;
    }

    /**
     * @param CollectionSupport $finalists
     * @return void
     */
    private function simulateFinals(CollectionSupport $finalists): void
    {
        if ($finalists->count() !== 2) {
            $this->error('Error: La final necesita exactamente 2 equipos.');
            return;
        }

        [$finalist1, $finalist2] = $finalists;

        $semiFinalGames = Game::latest()->take(2)->get();
        $losers = collect($this->getLosersFromRound($semiFinalGames));

        $thirdPlaceTeams = $losers->reject(fn($team) => in_array($team->id, [$finalist1->id, $finalist2->id]));

        if ($thirdPlaceTeams->count() === 2) {
            $thirdPlaceGame = $this->simulateThirdPlace($thirdPlaceTeams->first(), $thirdPlaceTeams->last());
        } else {
            $this->info("No se pudo jugar el partido por el tercer puesto");
            $thirdPlaceGame = null;
        }

        $finalGame = $this->simulateFinal($finalist1, $finalist2);

        $this->showFinalResults($finalGame, $thirdPlaceGame, $losers);
    }

    /**
     * @param Game $finalGame
     * @param Game|null $thirdPlaceGame
     * @param CollectionSupport $losers
     * @return void
     */
    private function showFinalResults(Game $finalGame, ?Game $thirdPlaceGame, CollectionSupport $losers): void
    {
        [$champion, $runnerUp] = $this->determineWinnerAndLoser($finalGame);

        $this->info("\n--- Clasificación Final ---");
        $this->info("1. Campeón: {$champion->name}");
        $this->info("2. Subcampeón: {$runnerUp->name}");

        if ($thirdPlaceGame) {
            [$thirdPlace, $fourthPlace] = $this->determineWinnerAndLoser($thirdPlaceGame);
            $this->info("3. Tercer puesto: {$thirdPlace->name}");
            $this->info("4. Cuarto puesto: {$fourthPlace->name}");
        }

        $classifiedTeams = [$champion->id, $runnerUp->id];
        if ($thirdPlaceGame) {
            $classifiedTeams[] = $thirdPlace->id;
            $classifiedTeams[] = $fourthPlace->id;
        }

        $remainingLosers = $losers->filter(fn($team) => !in_array($team->id, $classifiedTeams));

        foreach ($remainingLosers as $index => $team) {
            $this->info(($index + 5) . ". {$team->name}");
        }
    }

    /**
     * @param Team $teamLocal
     * @param Team $teamVisitor
     * @return Team
     */
    private function simulateGame(Team $teamLocal, Team $teamVisitor): Team
    {
        $localTeamScore = $this->getRandomGoles();
        $visitorTeamScore = $this->getRandomGoles();

        while ($localTeamScore === $visitorTeamScore) {
            $localTeamScore = $this->getRandomGoles();
            $visitorTeamScore = $this->getRandomGoles();
        }

        $this->info("Partido: {$teamLocal->name} ({$localTeamScore}) vs {$teamVisitor->name} ({$visitorTeamScore})");

        Game::create([
            'date' => now(),
            'status' => 'Finalizado',
            'team_local_score' => $localTeamScore,
            'team_visitor_score' => $visitorTeamScore,
            'team_local_id' => $teamLocal->id,
            'team_visitor_id' => $teamVisitor->id,
        ]);

        return $localTeamScore > $visitorTeamScore ? $teamLocal : $teamVisitor;
    }

    /**
     * @param Team $teamLocal
     * @param Team $teamVisitor
     * @return Game
     */
    private function simulateThirdPlace(Team $teamLocal, Team $teamVisitor): Game
    {
        $this->info("\nPartido por el tercer puesto:");
        $this->simulateGame($teamLocal, $teamVisitor);

        return Game::query()
            ->where('team_local_id', $teamLocal->id)
            ->where('team_visitor_id', $teamVisitor->id)
            ->latest()
            ->first();
    }

    /**
     * @param Team $teamLocal
     * @param Team $teamVisitor
     * @return Game
     */
    private function simulateFinal(Team $teamLocal, Team $teamVisitor): Game
    {
        $this->info("\nFinal:");
        $this->simulateGame($teamLocal, $teamVisitor);

        return Game::query()
            ->where('team_local_id', $teamLocal->id)
            ->where('team_visitor_id', $teamVisitor->id)
            ->latest()
            ->first();
    }

    /**
     * @param Game $game
     * @return array
     */
    private function determineWinnerAndLoser(Game $game): array
    {
        return $game->team_local_score > $game->team_visitor_score
            ? [$game->teamLocal, $game->teamVisitor]
            : [$game->teamVisitor, $game->teamLocal];
    }

    /**
     * @param CollectionSupport $games
     * @return array
     */
    private function getLosersFromRound(CollectionSupport $games): array
    {
        return $games->map(fn(Game $game) => $game->team_local_score < $game->team_visitor_score
            ? $game->teamLocal
            : $game->teamVisitor)->all();
    }

    /**
     * @return int
     */
    private function getRandomGoles(): int
    {
        return rand(0, 5);
    }
}
