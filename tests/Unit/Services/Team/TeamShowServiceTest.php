<?php

namespace Tests\Unit\Services\Team;

use App\Models\Team;
use App\Services\Team\TeamShowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamShowServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_team()
    {
        $team = Team::factory()->create();

        $service = new TeamShowService();
        $retrievedTeam = $service->execute($team);

        $this->assertTrue($retrievedTeam->is($team));
    }
}
