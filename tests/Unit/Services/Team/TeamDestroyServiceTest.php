<?php

namespace Tests\Unit\Services\Team;

use App\Models\Team;
use App\Services\Team\TeamDestroyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamDestroyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_team()
    {
        $team = Team::factory()->create();

        $service = new TeamDestroyService();
        $service->execute($team);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
