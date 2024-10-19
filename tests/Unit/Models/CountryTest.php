<?php

namespace Tests\Unit\Models;

use App\Models\Country;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_country_can_have_many_teams()
    {
        $country = Country::factory()->create();
        Team::factory()->count(2)->create(['country_id' => $country->id]);

        $this->assertCount(2, $country->teams);
    }
}
