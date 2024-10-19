<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_local_id' => Team::factory(),
            'team_visitor_id' => Team::factory(),
            'team_local_score' => rand(0, 5),
            'team_visitor_score' => rand(0, 5),
            'status' => 'Finalizado',
            'date' => now(),
        ];
    }
}
