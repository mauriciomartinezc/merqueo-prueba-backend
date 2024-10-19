<?php

namespace Tests\Unit\Services\Country;

use App\Models\Country;
use App\Services\Country\CountryIndexService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryIndexServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_countries()
    {
        Country::factory()->count(5)->create();

        $service = new CountryIndexService();
        $countries = $service->execute();

        $this->assertCount(5, $countries);
    }
}
