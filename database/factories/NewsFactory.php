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
        static $availableImages = null;

        if ($availableImages === null) {
            $availableImages = collect(glob(storage_path('app/public/news_images/*.*')))
                ->map(fn($path) => 'news_images/' . basename($path))
                ->shuffle();
        }

        $image = $availableImages->pop();

        return [
            'title' => $this->faker->catchPhrase(),
            'content' => $this->faker->paragraphs(10, true),
            'image' => $image,
            'categories' => $this->faker->randomElements(
                ['Новости', 'Статьи', 'События'],
                $this->faker->numberBetween(1, 3)
            ),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
