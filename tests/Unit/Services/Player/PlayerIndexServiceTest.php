<?php

namespace Tests\Unit\Services\Player;

use App\Models\Player;
use App\Services\Player\PlayerIndexService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerIndexServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_players()
    {
        Player::factory()->count(5)->create();

        $service = new PlayerIndexService();
        $players = $service->execute();

        $this->assertCount(5, $players);
    }
}
