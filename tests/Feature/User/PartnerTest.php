<?php

namespace Tests\Feature;

use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);


it('correctly displays the partners to the user', function () {

    $names = ['Matilda', 'Bob', 'Arnak', 'Gupee', 'John'];

    for ($i = 0; $i < 5; $i++) {
        Partner::factory()->create([
            'name' => $names[$i],
        ]);
    }

    $response = $this->get(route('user.partners.index'));

    $response->assertStatus(200);

    Partner::all()->each(function ($partner) use ($response) {
        $response->assertSee($partner->name);
        $response->assertSee($partner->info);
    });
});



it('correctly displays the show partner page to the user', function () {

    $partner = Partner::factory()->create();

    $response = $this->get(route('user.partner.show', $partner));

    $response->assertStatus(200);

    $response->assertSee($partner->name);
    $response->assertSee($partner->info);

});
