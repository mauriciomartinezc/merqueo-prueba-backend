<?php

namespace Tests\Unit\Models;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_player_belongs_to_a_team()
    {
        $team = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $team->id]);

        $this->assertTrue($player->team->is($team));
    }
}
