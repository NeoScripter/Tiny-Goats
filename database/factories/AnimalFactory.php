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
        $client = new Client();
        $images = [];

        $pixabayUrl = 'https://pixabay.com/api/?key=47185109-3d7800540e3a0a59061a64e22&q=goat&image_type=photo';

        $response = $client->get($pixabayUrl);
        $data = json_decode($response->getBody(), true);

        if (isset($data['hits'])) {
            $shuffledHits = collect($data['hits'])->shuffle();

            foreach ($shuffledHits->take(4) as $hit) {
                $imageUrl = $hit['webformatURL'];
                $response = $client->get($imageUrl);
                $imageName = 'animals_images/' . Str::random(10) . '.jpg';

                Storage::disk('public')->put($imageName, $response->getBody());
                $images[] = $imageName;
            }
        }


        return [
            'name' => $this->faker->firstName,
            'isMale' => $this->faker->boolean,
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
            'images' => $images,
            'mother_id' => null,
            'father_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
