<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => $this->faker->sentence(6, true),
            'content' => $this->faker->paragraphs(3, true),
            /* 'image' => 'news_images/' . $this->faker->image('public/storage/news_images', 640, 480, null, false), */
            'categories' => $this->faker->randomElements(
                ['Новости', 'Статьи', 'События'],
                $this->faker->numberBetween(1, 3)
            ),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
