<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialist>
 */
class SpecialistFactory extends Factory
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
            $availableImages = collect(glob(storage_path('app/public/specialists/*.*')))
                ->map(fn($path) => 'specialists/' . basename($path))
                ->shuffle();
        }

        $image = $availableImages->pop();


        return [
            'name' => $this->faker->name(),
            'image_path' => $image,
            'speciality' => $this->faker->jobTitle(),
            'educaiton' => $this->faker->words(10, true),
            'experience' => $this->faker->words(10, true),
            'extraInfo' => $this->faker->words(10, true),
            'contacts' => $this->faker->words(10, true),
            'website' => $this->faker->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
