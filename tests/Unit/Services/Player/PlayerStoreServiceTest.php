<?php

namespace Tests\Unit\Services\Player;

use App\Models\Team;
use App\Services\Player\PlayerStoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerStoreServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_new_player()
    {
        $team = Team::factory()->create();

        $data = [
            'name' => 'Mauricio',
            'age' => 31,
            'position' => 'Defensa',
            'nationality' => 'Colombiano',
            'shirt_number' => 5,
            'photo' => 'photos/default.png',
            'team_id' => $team->id,
        ];

        $service = new PlayerStoreService();
        $service->execute($data);

        $this->assertDatabaseHas('players', ['name' => 'Mauricio']);
    }
}
