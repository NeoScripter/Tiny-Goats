<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Household>
 */
class HouseholdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $availableImages = null;

        if ($availableImages === null) {
            $availableImages = collect(glob(storage_path('app/public/households/*.*')))
                ->map(fn($path) => 'households/' . basename($path))
                ->shuffle();
        }

        $image = $availableImages->pop();


        return [
            'name' => $this->faker->company(),
            'image' => $image,
            'address' => $this->faker->address(),
            'owner' => $this->faker->name(),
            'country' => $this->faker->country(),
            'region' => $this->faker->state(),
            'extraInfo' => $this->faker->words(20, true),
            'breeds' => $this->faker->words(20, true),
            'contacts' => $this->faker->words(10, true),
            'website' => $this->faker->url(),
            'showOnMain' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
