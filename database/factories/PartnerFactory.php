<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
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
            $availableImages = collect(glob(storage_path('app/public/partners/*.*')))
                ->map(fn($path) => 'partners/' . basename($path))
                ->shuffle();
        }

        $image = $availableImages->pop();


        return [
            'name' => $this->faker->name(),
            'image' => $image,
            'info' => $this->faker->words(10, true),
            'conditions' => $this->faker->words(10, true),
            'contacts' => $this->faker->words(10, true),
            'website' => $this->faker->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
