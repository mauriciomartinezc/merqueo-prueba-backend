<?php

namespace Tests\Unit\Services\Team;

use App\Models\Team;
use App\Services\Team\TeamIndexService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamIndexServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_teams()
    {
        Team::factory()->count(5)->create();

        $service = new TeamIndexService();
        $teams = $service->execute();

        $this->assertCount(5, $teams);
    }
}
