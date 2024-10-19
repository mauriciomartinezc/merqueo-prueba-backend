<?php

namespace Tests\Unit\Services\Team;

use App\Models\Team;
use App\Services\Team\TeamUpdateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamUpdateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_team()
    {
        $team = Team::factory()->create(['name' => 'Mauricio Martinez']);

        $data = ['name' => 'Mauricio Martinez Chaves'];

        $service = new TeamUpdateService();
        $updatedTeam = $service->execute($team, $data);

        $this->assertDatabaseHas('teams', ['name' => 'Mauricio Martinez Chaves']);
    }
}
