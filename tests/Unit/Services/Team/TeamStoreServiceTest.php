<?php

namespace Tests\Unit\Services\Team;

use App\Services\Team\TeamStoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamStoreServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_new_team()
    {
        $data = [
            'name' => 'Mauricio',
            'flag_image' => 'flags/default.png',
            'country' => 1,
        ];

        $service = new TeamStoreService();
        $service->execute($data);

        $this->assertDatabaseHas('teams', ['name' => 'Mauricio']);
    }
}
