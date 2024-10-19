<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\PlayerController;
use App\Http\Requests\Player\PlayerRequest;
use App\Models\Player;
use App\Services\Player\PlayerDestroyService;
use App\Services\Player\PlayerIndexService;
use App\Services\Player\PlayerShowService;
use App\Services\Player\PlayerStoreService;
use App\Services\Player\PlayerUpdateService;
use App\Services\Team\TeamIndexService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function mockPaginated($items, $total = 50, $perPage = 15): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    public function test_index_displays_players(): void
    {
        $players = $this->mockPaginated(collect());
        $playerIndexService = Mockery::mock(PlayerIndexService::class);
        $playerIndexService->shouldReceive('execute')->andReturn($players);

        $controller = new PlayerController(
            $playerIndexService,
            Mockery::mock(PlayerStoreService::class),
            Mockery::mock(PlayerShowService::class),
            Mockery::mock(PlayerUpdateService::class),
            Mockery::mock(PlayerDestroyService::class),
            Mockery::mock(TeamIndexService::class)
        );

        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('players.index', $response->name());
    }

    public function test_store_creates_new_player()
    {
        $request = Mockery::mock(PlayerRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'name' => 'Mauricio Martinez Chaves',
            'age' => 31,
            'position' => 'Defensa',
            'shirt_number' => 5,
            'nationality' => 'Colombiano',
            'photo' => 'photos/default.png',
            'team_id' => 1
        ]);

        $playerStoreService = Mockery::mock(PlayerStoreService::class);
        $playerStoreService->shouldReceive('execute')->once();

        $controller = new PlayerController(
            Mockery::mock(PlayerIndexService::class),
            $playerStoreService,
            Mockery::mock(PlayerShowService::class),
            Mockery::mock(PlayerUpdateService::class),
            Mockery::mock(PlayerDestroyService::class),
            Mockery::mock(TeamIndexService::class)
        );

        $response = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/players'), $response->getTargetUrl());
    }

    public function test_destroy_removes_player()
    {
        $player = Player::factory()->create();

        $playerDestroyService = Mockery::mock(PlayerDestroyService::class);
        $playerDestroyService->shouldReceive('execute')->once();

        $controller = new PlayerController(
            Mockery::mock(PlayerIndexService::class),
            Mockery::mock(PlayerStoreService::class),
            Mockery::mock(PlayerShowService::class),
            Mockery::mock(PlayerUpdateService::class),
            $playerDestroyService,
            Mockery::mock(TeamIndexService::class)
        );

        $response = $controller->destroy($player);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/players'), $response->getTargetUrl());
    }
}
