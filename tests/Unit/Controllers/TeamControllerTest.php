<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\TeamController;
use App\Http\Requests\Team\TeamRequest;
use App\Models\Team;
use App\Services\Country\CountryIndexService;
use App\Services\Team\TeamDestroyService;
use App\Services\Team\TeamIndexService;
use App\Services\Team\TeamShowService;
use App\Services\Team\TeamStoreService;
use App\Services\Team\TeamUpdateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function mockPaginated($items, $total = 50, $perPage = 15): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage() ?: 1;
        return new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
        ]);
    }

    public function test_index_displays_teams(): void
    {
        $teams = $this->mockPaginated(collect());
        $teamIndexService = Mockery::mock(TeamIndexService::class);
        $teamIndexService->shouldReceive('execute')->andReturn($teams);

        $controller = new TeamController(
            $teamIndexService,
            Mockery::mock(TeamStoreService::class),
            Mockery::mock(TeamShowService::class),
            Mockery::mock(TeamUpdateService::class),
            Mockery::mock(TeamDestroyService::class),
            Mockery::mock(CountryIndexService::class)
        );

        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('teams.index', $response->name());
    }

    public function test_store_creates_new_team()
    {
        $request = Mockery::mock(TeamRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'name' => 'Mauricio',
            'flag_image' => 'flags/default.png',
            'country_id' => 1
        ]);

        $teamStoreService = Mockery::mock(TeamStoreService::class);
        $teamStoreService->shouldReceive('execute')->once();

        $controller = new TeamController(
            Mockery::mock(TeamIndexService::class),
            $teamStoreService,
            Mockery::mock(TeamShowService::class),
            Mockery::mock(TeamUpdateService::class),
            Mockery::mock(TeamDestroyService::class),
            Mockery::mock(CountryIndexService::class)
        );

        $response = $controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/teams'), $response->getTargetUrl());
    }

    public function test_destroy_removes_team()
    {
        $team = Team::factory()->create();

        $teamDestroyService = Mockery::mock(TeamDestroyService::class);
        $teamDestroyService->shouldReceive('execute')->once();

        $controller = new TeamController(
            Mockery::mock(TeamIndexService::class),
            Mockery::mock(TeamStoreService::class),
            Mockery::mock(TeamShowService::class),
            Mockery::mock(TeamUpdateService::class),
            $teamDestroyService,
            Mockery::mock(CountryIndexService::class)
        );

        $response = $controller->destroy($team);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/teams'), $response->getTargetUrl());
    }
}
