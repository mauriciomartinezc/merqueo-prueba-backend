<?php

namespace Tests\Unit\Models;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_game_belongs_to_a_local_and_visitor_team()
    {
        $localTeam = Team::factory()->create();
        $visitorTeam = Team::factory()->create();

        $game = Game::factory()->create([
            'team_local_id' => $localTeam->id,
            'team_visitor_id' => $visitorTeam->id,
        ]);

        $this->assertTrue($game->teamLocal->is($localTeam));
        $this->assertTrue($game->teamVisitor->is($visitorTeam));
    }
}
