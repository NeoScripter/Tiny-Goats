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
        $imageUrl = 'https://picsum.photos/800/600';
        $client = new Client();
        $response = $client->get($imageUrl);
        $imageName = 'news_images/' . Str::random(10) . '.jpg';

        // Store the image in the public storage
        Storage::disk('public')->put($imageName, $response->getBody());

        return [
            'title' => $this->faker->catchPhrase(),
            'content' => $this->faker->paragraphs(3, true),
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
