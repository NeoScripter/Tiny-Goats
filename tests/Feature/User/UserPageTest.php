<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('correctly displays the home page', function () {
    Animal::factory()->count(10)->create([
        'showOnMain' => true,
    ]);

    News::factory()->count(4)->create();

    $response = $this->get('/');

    $response->assertStatus(200);

    $response->assertSee('Задачи, решаемые Реестром');

    Animal::where('showOnMain', true)->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
    });

    News::all()->each(function ($news) use ($response) {
        $response->assertSee($news->title);
    });
});


it('correctly displays the for sale page', function () {
    Animal::factory()->count(10)->create([
        'forSale' => true,
    ]);

    $response = $this->get('/sell');

    $response->assertStatus(200);

    $response->assertSee('Животные на продажу');

    Animal::where('forSale', true)->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->image);
    });

});

it('correctly displays the news page', function () {

    News::factory()->count(16)->create();

    $response = $this->get(route('user.news.index'));

    $response->assertStatus(200);

    $response->assertSee('Новости и статьи');

    News::all()->each(function ($news) use ($response) {
        $response->assertSee($news->title);
        $response->assertSee($news->image);
    });
});

it('displays only the news from the selected category', function () {

    News::factory()->count(7)->create([
        'categories' => ['Новости'],
    ]);

    News::factory()->count(3)->create([
        'categories' => ['Статьи'],
    ]);

    News::factory()->count(5)->create([
        'categories' => ['События'],
    ]);

    $response = $this->get('/news/category/Новости');
    $response->assertStatus(200);

    $response->assertSeeInOrder([
        'class="news__category news__category--active"',
        'Новости'
    ], false);

    $news = News::whereJsonContains('categories', 'Новости')->get();
    $news->each(function ($news) use ($response) {
        $response->assertSee($news->title);
        $response->assertSee($news->image);
    });

    expect($news)->toHaveCount(7);

    // Next category

    $response = $this->get('/news/category/Статьи');
    $response->assertStatus(200);

    $response->assertSeeInOrder([
        'class="news__category news__category--active"',
        'Статьи'
    ], false);

    $news = News::whereJsonContains('categories', 'Статьи')->get();
    $news->each(function ($news) use ($response) {
        $response->assertSee($news->title);
        $response->assertSee($news->image);
    });

    expect($news)->toHaveCount(3);

    // Next category

    $response = $this->get('/news/category/События');
    $response->assertStatus(200);

    $response->assertSeeInOrder([
        'class="news__category news__category--active"',
        'События'
    ], false);

    $news = News::whereJsonContains('categories', 'События')->get();
    $news->each(function ($news) use ($response) {
        $response->assertSee($news->title);
        $response->assertSee($news->image);
    });

    expect($news)->toHaveCount(5);
});

it('correctly displays the rules page', function () {

    $response = $this->get('/rules');

    $response->assertStatus(200);

    $response->assertSee('Предлагаем ознакомиться с правилами нашего сайта “Реестр карликовых коз России”');
    $response->assertSee('Мы надеемся на честное');
});

it('correctly displays the contacts page', function () {

    $response = $this->get('/contacts');

    $response->assertStatus(200);

    $response->assertSee('Наши контакты');
});

it('correctly displays the faq page', function () {

    $response = $this->get('/faq');

    $response->assertStatus(200);

    $response->assertSee('Ответы на популярные вопросы');
    $response->assertSee('Как стать донатером сайта');
});

it('correctly displays the register page', function () {

    $response = $this->get('/register');

    $response->assertStatus(200);

    $response->assertSee('Регистрация в Реестре');
    $response->assertSee('остались вопросы');
});
