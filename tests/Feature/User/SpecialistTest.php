<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\News;
use App\Models\Specialist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);


it('correctly displays the specialists to the user', function () {

    $names = ['Matilda', 'Bob', 'Arnak', 'Gupee', 'John'];

    for ($i = 0; $i < 5; $i++) {
        Specialist::factory()->create([
            'name' => $names[$i],
        ]);
    }

    $response = $this->get(route('specialists.index'));

    $response->assertStatus(200);

    Specialist::all()->each(function ($specialist) use ($response) {
        $response->assertSee($specialist->name);
        $response->assertSee($specialist->speciality);
    });

    // Make a name query

    $response = $this->get('/specialists?name=Matilda');

    $response->assertStatus(200);

    Specialist::where('name', 'not like', "%Matilda%")->get()->each(function ($specialist) use ($response) {
        $response->assertDontSee($specialist->name);
        $response->assertDontSee($specialist->speciality);
    });

    Specialist::where('name', 'like', "%Matilda%")->get()->each(function ($specialist) use ($response) {
        $response->assertSee($specialist->name);
        $response->assertSee($specialist->speciality);
    });

    // Make a character query

    $response = $this->get('/specialists?char=B');

    $response->assertStatus(200);

    Specialist::where('name', 'not like', "B%")->get()->each(function ($specialist) use ($response) {
        $response->assertDontSee($specialist->name);
        $response->assertDontSee($specialist->speciality);
    });

    Specialist::where('name', 'like', "B%")->get()->each(function ($specialist) use ($response) {
        $response->assertSee($specialist->name);
        $response->assertSee($specialist->speciality);
    });
});



it('correctly displays the show specialist page to the user', function () {

    $specialist = Specialist::factory()->create();

    $response = $this->get(route('user.specialist.show', $specialist));

    $response->assertStatus(200);

    $response->assertSee($specialist->name);
    $response->assertSee($specialist->speciality);

});
