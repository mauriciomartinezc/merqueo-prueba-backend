<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;

class TeamAndPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $countriesInUse = Team::all()->pluck('country_id')->toArray();
        $countries = Country::all()->whereNotIn('id', $countriesInUse)->random(10);

        foreach ($countries as $country) {
            $team = Team::create([
                'name' => 'Equipo de ' . $country->name,
                'country_id' => $country->id,
                'flag_image' => 'flags/default.png',
            ]);

            for ($i = 1; $i <= 22; $i++) {
                Player::create([
                    'team_id' => $team->id,
                    'name' => 'Jugador ' . $i . ' de ' . $team->name,
                    'nationality' => $country->name,
                    'age' => rand(18, 35),
                    'position' => $this->getRandomPosition(),
                    'shirt_number' => $i,
                    'photo' => 'photos/default.png',
                ]);
            }
        }
    }

    /**
     * @return string
     */
    private function getRandomPosition(): string
    {
        $positions = ['Portero', 'Defensa', 'Centrocampista', 'Delantero'];
        return $positions[array_rand($positions)];
    }
}
