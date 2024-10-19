<?php

namespace Tests\Unit\Services\Player;

use App\Models\Player;
use App\Services\Player\PlayerDestroyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerDestroyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_player()
    {
        $player = Player::factory()->create();

        $service = new PlayerDestroyService();
        $service->execute($player);

        $this->assertDatabaseMissing('players', ['id' => $player->id]);
    }
}
