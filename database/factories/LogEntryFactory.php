<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Household;
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
        $male = Animal::inRandomOrder()->first() ?? Animal::factory()->create(['isMale' => true]);
        $female = Animal::inRandomOrder()->first() ?? Animal::factory()->create(['isMale' => false]);
        $household = Household::inRandomOrder()->first() ?? Household::factory()->create();

        return [
            'number' => $this->faker->randomDigit(),
            'household_id' => $household->id,
            'male_id' => $male->id,
            'female_id' => $female->id,
            'coverage' => $this->faker->word(),
            'lambing' => $this->faker->word(),
            'status' => $this->faker->words(3, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
