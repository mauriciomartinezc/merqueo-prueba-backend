<?php

namespace Tests\Unit\Console\Commands;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SimulateGamesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Game::truncate();
        Team::truncate();
    }

    public function it_can_simulate_a_tournament_with_valid_teams(): void
    {
        Team::factory()->count(16)->create();

        Artisan::call('simulate:games', ['teamsCount' => 16]);

        $this->assertDatabaseCount('games', 15);

        $lastGame = Game::orderBy('date', 'desc')->first();
        $this->assertNotNull($lastGame);
        $this->assertNotEquals($lastGame->team_local_score, $lastGame->team_visitor_score);
    }

    public function it_fails_if_teams_count_is_odd(): void
    {
        Artisan::call('simulate:games', ['teamsCount' => 15]);
        $this->assertDatabaseCount('games', 0);
        $output = Artisan::output();
        $this->assertStringContainsString('el número de equipos sea un número par', $output);
    }

    public function it_simulates_final_and_third_place(): void
    {
        Team::factory()->count(4)->create();
        Artisan::call('simulate:games', ['teamsCount' => 4]);

        $this->assertDatabaseCount('games', 3);

        $thirdPlaceGame = Game::latest()->where('status', 'Finalizado')->skip(1)->first();
        $this->assertNotNull($thirdPlaceGame);
        $this->assertNotEquals($thirdPlaceGame->team_local_score, $thirdPlaceGame->team_visitor_score);
    }

    public function it_prevents_duplicates_in_winner_selection(): void
    {
        Team::factory()->count(8)->create();

        Artisan::call('simulate:games', ['teamsCount' => 8]);

        $finalists = Game::orderBy('date', 'desc')->take(2)->get();
        $teamIds = [$finalists[0]->team_local_id, $finalists[0]->team_visitor_id, $finalists[1]->team_local_id, $finalists[1]->team_visitor_id];

        $this->assertCount(4, array_unique($teamIds));
    }

    public function it_does_not_allow_ties_in_any_game(): void
    {
        Team::factory()->count(16)->create();

        Artisan::call('simulate:games', ['teamsCount' => 16]);

        $games = Game::all();
        foreach ($games as $game) {
            $this->assertNotEquals($game->team_local_score, $game->team_visitor_score);
        }
    }
}
