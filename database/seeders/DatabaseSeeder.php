<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Storage::disk('public')->deleteDirectory('animals_images');
        Storage::disk('public')->makeDirectory('animals_images');
        Storage::disk('public')->deleteDirectory('news_images');
        Storage::disk('public')->makeDirectory('news_images');


        $this->call([
            UserSeeder::class,
            NewsSeeder::class,
            AnimalSeeder::class
        ]);
    }
}
