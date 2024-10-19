<?php

namespace Tests\Unit\Models;

use App\Models\Country;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_team_belongs_to_a_country()
    {
        $country = Country::factory()->create();
        $team = Team::factory()->create(['country_id' => $country->id]);

        $this->assertTrue($team->country->is($country));
    }

    #[Test]
    public function a_team_has_many_players()
    {
        $team = Team::factory()->create();
        Player::factory()->count(2)->create(['team_id' => $team->id]);

        $this->assertCount(2, $team->players);
    }
}
