<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'character' => $this->faker->firstName(50),
            'words' => $this->faker->paragraph(1000),
            'episode_name' => $this->faker->text(50),
            'episode_number' => rand(0, 30),
            'series_number' => rand(0, 34),
        ];
    }
}
