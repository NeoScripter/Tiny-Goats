<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('correctly displays the animals page to the user', function () {

    $is_male = [true, false, true, false, true];
    $names = ['Matilda', 'Bob', 'Arnak', 'Gupee', 'John'];
    $breeds = ['нигерийская', 'нигерийско-камерунская', 'камерунская', 'метис', 'другие'];

    for ($i = 0; $i < 5; $i++) {
        Animal::factory()->create([
            'name' => $names[$i],
            'isMale' => $is_male[$i],
            'breed' => $breeds[$i],
        ]);
    }

    $response = $this->get(route('user.animals.index'));

    $response->assertStatus(200);

    Animal::all()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->isMale ? 'Самец' :'Самка');
        $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    // Make a breed query

    $response = $this->get('/animals?breed=нигерийская');

    $response->assertStatus(200);

    Animal::where('breed', '!=', 'нигерийская')->get()->each(function ($animal) use ($response) {
        $response->assertDontSee($animal->name);
        $response->assertDontSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    Animal::where('breed', 'нигерийская')->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->isMale ? 'Самец' :'Самка');
        $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    // Make a gender query

    $response = $this->get('/animals?gender=male');

    $response->assertStatus(200);

    Animal::where('isMale', '!=', true)->get()->each(function ($animal) use ($response) {
        $response->assertDontSee($animal->name);
        $response->assertDontSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    Animal::where('isMale', true)->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->isMale ? 'Самец' :'Самка');
        $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    // Make a name query

    $response = $this->get('/animals?name=Matilda');

    $response->assertStatus(200);

    Animal::where('name', 'not like', "%Matilda%")->get()->each(function ($animal) use ($response) {
        $response->assertDontSee($animal->name);
        $response->assertDontSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    Animal::where('name', 'like', "%Matilda%")->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->isMale ? 'Самец' :'Самка');
        $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    // Make a character query

    $response = $this->get('/animals?char=B');

    $response->assertStatus(200);

    Animal::where('name', 'not like', "B%")->get()->each(function ($animal) use ($response) {
        $response->assertDontSee($animal->name);
        $response->assertDontSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });

    Animal::where('name', 'like', "B%")->get()->each(function ($animal) use ($response) {
        $response->assertSee($animal->name);
        $response->assertSee($animal->isMale ? 'Самец' :'Самка');
        $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));
    });
});


it('correctly displays the show animal page to the user', function () {

    $animal = Animal::factory()->create();

    $response = $this->get(route('user.animals.show', $animal));

    $response->assertStatus(200);

    $response->assertSee($animal->name);
    $response->assertSee($animal->isMale ? 'Самец' :'Самка');
    $response->assertSee(\Carbon\Carbon::parse($animal->birthDate)->format('d.m.Y'));

});

it('correctly displays the coupling page to the user', function () {

    $response = $this->get('/coupling');

    $response->assertStatus(200);

    $response->assertSee('Родословная планируемого окота');

});
