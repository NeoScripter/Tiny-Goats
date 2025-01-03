<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LogEntry>
 */
class LogEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomDigit(),
            'male_id' => null,
            'female_id' => null,
            'coverage' => $this->faker->word(),
            'lambing' => $this->faker->word(),
            'status' => $this->faker->words(3, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
