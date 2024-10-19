<?php

namespace Tests\Unit\Services\Player;

use App\Models\Player;
use App\Services\Player\PlayerShowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerShowServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_player()
    {
        $player = Player::factory()->create();

        $service = new PlayerShowService();
        $retrievedPlayer = $service->execute($player);

        $this->assertTrue($retrievedPlayer->is($player));
    }
}
