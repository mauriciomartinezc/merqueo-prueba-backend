<?php

namespace Tests\Unit\Services\Game;

use App\Models\Game;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_games_grouped_by_round()
    {
        Game::factory()->count(8)->create(); // 8 partidos -> 3 rondas en total

        $service = new GameService();
        $gamesByRound = $service->getGamesGroupedByRound();

        $this->assertEquals(3, $gamesByRound->count());
    }

    public function test_it_returns_final_game()
    {
        Game::factory()->count(10)->create();
        $finalGame = Game::factory()->create(['status' => 'Finalizado']);

        $service = new GameService();
        $retrievedFinalGame = $service->getFinalGame();

        $this->assertTrue($retrievedFinalGame->is($finalGame));
    }

    public function test_it_returns_third_place_game()
    {
        Game::factory()->count(10)->create();
        $finalGame = Game::factory()->create(['status' => 'Finalizado']);
        $thirdPlaceGame = Game::factory()->create(['status' => 'Finalizado']);

        $service = new GameService();
        $retrievedThirdPlaceGame = $service->getThirdPlaceGame($finalGame);

        $this->assertTrue($retrievedThirdPlaceGame->is($thirdPlaceGame));
    }
}
