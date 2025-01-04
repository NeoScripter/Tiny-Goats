<?php

namespace Tests\Feature;

use App\Models\Animal;
use App\Models\News;
use App\Models\Household;
use App\Models\LogEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);


it('correctly displays the households to the user', function () {

    $names = ['Matilda', 'Bob', 'Arnak', 'Gupee', 'John'];

    for ($i = 0; $i < 5; $i++) {
        Household::factory()->create([
            'name' => $names[$i],
        ]);
    }

    $response = $this->get(route('user.households.index'));

    $response->assertStatus(200);

    Household::all()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->owner);
    });

    // Make a name query

    $response = $this->get('/households?name=Matilda');

    $response->assertStatus(200);

    Household::where('name', 'not like', "%Matilda%")->get()->each(function ($household) use ($response) {
        $response->assertDontSee($household->name);
        $response->assertDontSee($household->owner);
    });

    Household::where('name', 'like', "%Matilda%")->get()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->owner);
    });

    // Make a character query

    $response = $this->get('/households?char=B');

    $response->assertStatus(200);

    Household::where('name', 'not like', "B%")->get()->each(function ($household) use ($response) {
        $response->assertDontSee($household->name);
        $response->assertDontSee($household->owner);
    });

    Household::where('name', 'like', "B%")->get()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->owner);
    });
});



it('correctly displays the show household page to the user', function () {

    $household = Household::factory()->create();

    LogEntry::factory()->count(10)->create();

    $response = $this->get(route('user.household.show', $household));

    $response->assertStatus(200);

    $response->assertSee($household->name);
    $response->assertSee($household->extraInfo);

    LogEntry::all()->each(function ($entry) use ($response) {
        $response->assertSee($entry->number);
        $response->assertSee($entry->coverage);
    });

});
