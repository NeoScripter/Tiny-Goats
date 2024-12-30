<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the list of news items', function () {
    actingAsAdmin();

    News::factory()->count(5)->create();

    $response = $this->get(route('news.index'));

    $response->assertStatus(200)
        ->assertViewIs('admin.news.index')
        ->assertViewHas('newsItems', fn($newsItems) => $newsItems->count() === 5);

    $response->assertSee('Новости и статьи');
});

it('shows the create news form', function () {
    actingAsAdmin();

    $response = $this->get(route('news.create'));

    $response->assertStatus(200)
        ->assertViewIs('admin.news.create');

    $response->assertSee('Введите заголовок');
});

it('stores a new news item with an image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $response = $this->post(route('news.store'), [
        'title' => 'Test News Title',
        'content' => 'Test content for the news.',
        'categories' => ['Category1', 'Category2'],
        'image' => UploadedFile::fake()->image('news.jpg'),
    ]);

    $response->assertRedirect(route('news.index'))
        ->assertSessionHas('success', 'Новость успешно создана!');

    $this->assertTrue(
        News::where('title', 'Test News Title')
            ->where('content', 'Test content for the news.')
            ->whereRaw("categories::jsonb = ?", [json_encode(['Category1', 'Category2'])])
            ->exists()
    );

    $news = News::latest()->first();

    $this->assertTrue(Storage::disk('public')->exists($news->image));
});

it('shows a specific news item', function () {
    actingAsAdmin();

    $news = News::factory()->create();

    $other_news = News::factory()->count(3)->create();

    $response = $this->get(route('news.show', $news));

    $response->assertStatus(200)
        ->assertViewIs('admin.news.show')
        ->assertViewHas('news', $news)
        ->assertSee($news->title)
        ->assertSee($news->image)
        ->assertSee($news->content);


    foreach ($other_news as $related_news) {
        $response->assertSee($related_news->title);
        $response->assertSee($related_news->image);
    }
});

it('shows the edit form for a news item', function () {
    actingAsAdmin();

    $news = News::factory()->create();

    $response = $this->get(route('news.edit', $news));

    $response->assertStatus(200)
        ->assertViewIs('admin.news.edit')
        ->assertViewHas('news', $news)
        ->assertSee($news->content);
});

it('updates a news item', function () {
    actingAsAdmin();

    $news = News::factory()->create([
        'title' => 'Old Title',
    ]);

    $old_image = $news->image;

    Storage::fake('public');
    $image = UploadedFile::fake()->image('new_image.jpg');

    $response = $this->put(route('news.update', $news), [
        'title' => 'Updated Title',
        'content' => 'Updated content for the news.',
        'categories' => ['UpdatedCategory'],
        'image' => $image,
    ]);

    $response->assertRedirect(route('news.index'))
        ->assertSessionHas('success', 'Новость успешно обновлена!');

    $this->assertTrue(
        News::where('title', 'Updated Title')
            ->where('id', $news->id)
            ->where('content', 'Updated content for the news.')
            ->whereRaw("categories::jsonb = ?", [json_encode(['UpdatedCategory'])])
            ->exists()
    );

    $news = News::latest()->first();

    $this->assertFalse(Storage::disk('public')->exists($old_image));
    $this->assertTrue(Storage::disk('public')->exists($news->image));
});

it('deletes a news item and removes the image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $news = News::factory()->create([
        'image' => 'news_images/news.jpg',
    ]);

    Storage::disk('public')->put('news_images/news.jpg', 'dummy content');

    $this->assertTrue(Storage::disk('public')->exists('news_images/news.jpg'));

    $response = $this->delete(route('news.destroy', $news));

    $response->assertRedirect(route('news.index'))
        ->assertSessionHas('success', 'Новость успешно удалена!');

    $this->assertDatabaseMissing('news', ['id' => $news->id]);

    $this->assertFalse(Storage::disk('public')->exists($news->image));
});
