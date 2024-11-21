<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = new Client();
        $imageName = '';

        $pixabayUrl = 'https://pixabay.com/api/?key=47185109-3d7800540e3a0a59061a64e22&q=news&image_type=photo';

        $response = $client->get($pixabayUrl);
        $data = json_decode($response->getBody(), true);

        if (isset($data['hits'])) {
            $shuffledHits = collect($data['hits'])->shuffle();

            $hit = $shuffledHits[0];
            $imageUrl = $hit['webformatURL'];
            $response = $client->get($imageUrl);
            $imageName = 'news_images/' . Str::random(10) . '.jpg';

            Storage::disk('public')->put($imageName, $response->getBody());
        }

        return [
            'title' => $this->faker->catchPhrase(),
            'content' => $this->faker->paragraphs(10, true),
            'image' => $imageName,
            'categories' => $this->faker->randomElements(
                ['Новости', 'Статьи', 'События'],
                $this->faker->numberBetween(1, 3)
            ),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
