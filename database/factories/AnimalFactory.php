<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Animal::class;

    public function definition(): array
    {
        static $availableImages = null;

        if ($availableImages === null) {
            $availableImages = collect(glob(storage_path('app/public/animals_images/*.*')))
                ->map(fn($path) => 'animals_images/' . basename($path))
                ->shuffle();
        }

        $gender_bool = $this->faker->boolean;

        $image = $availableImages->pop();

        return [
            'name' => $this->faker->firstName($gender_bool ? 'male' :'female'),
            'isMale' => $gender_bool,
            'breed' => $this->faker->randomElement(['нигерийская', 'нигерийско-камерунская', 'камерунская', 'метис', 'другие']),
            'forSale' => $this->faker->boolean,
            'color' => $this->faker->safeColorName,
            'eyeColor' => $this->faker->safeColorName,
            'birthDate' => $this->faker->date(),
            'direction' => $this->faker->word,
            'siblings' => $this->faker->numberBetween(0, 5),
            'hornedness' => $this->faker->randomElement(['Horned', 'Polled']),
            'birthCountry' => $this->faker->country,
            'residenceCountry' => $this->faker->country,
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'labelNumber' => Str::random(8),
            'height' => $this->faker->numberBetween(120, 180) . ' cm',
            'rudiment' => $this->faker->word,
            'extraInfo' => $this->faker->paragraph,
            'certificates' => $this->faker->paragraph,
            'showOnMain' => $this->faker->boolean,
            'images' => [$image, $image, $image],
            'mother_id' => null,
            'father_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
