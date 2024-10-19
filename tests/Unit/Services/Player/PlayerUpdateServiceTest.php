<?php

namespace Tests\Unit\Services\Player;

use App\Models\Player;
use App\Services\Player\PlayerUpdateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerUpdateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_player()
    {
        $player = Player::factory()->create(['name' => 'Mauricio Martinez']);

        $data = ['name' => 'Mauricio Martinez Chaves'];

        $service = new PlayerUpdateService();
        $service->execute($player, $data);

        $this->assertDatabaseHas('players', ['name' => 'Mauricio Martinez Chaves']);
    }
}
