<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->randomNumber(),
            'position' => $this->faker->jobTitle,
            'shirt_number' => $this->faker->randomNumber(),
            'photo' => $this->faker->imageUrl(),
            'nationality' => $this->faker->country(),
            'team_id' => Team::factory(),
        ];
    }
}
