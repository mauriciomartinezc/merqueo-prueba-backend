<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\TournamentController;
use App\Services\Game\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class TournamentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $gameService;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gameService = Mockery::mock(GameService::class);
        $this->controller = new TournamentController($this->gameService);
    }

    public function index_displays_games_by_round_and_finals(): void
    {
        $gamesByRound = collect();
        $finalGame = null;
        $thirdPlaceGame = null;

        $this->gameService->shouldReceive('getGamesGroupedByRound')->andReturn($gamesByRound);
        $this->gameService->shouldReceive('getFinalGame')->andReturn($finalGame);
        $this->gameService->shouldReceive('getThirdPlaceGame')->with($finalGame)->andReturn($thirdPlaceGame);

        $response = $this->controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('tournaments.index', $response->name());
        $this->assertArrayHasKey('gamesByRound', $response->getData());
        $this->assertArrayHasKey('finalGame', $response->getData());
    }

    public function generate_calls_artisan_and_redirects(): void
    {
        Artisan::shouldReceive('call')->once()->with('simulate:games');

        $response = $this->controller->generate();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('tournaments.index'), $response->getTargetUrl());
    }
}
