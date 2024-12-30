<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;
use Carbon\Carbon;

uses(RefreshDatabase::class);

it('correctly displays the admin page and last changes on it', function () {

    $animal1DayAgo = Animal::factory()->create([
        'updated_at' => Carbon::now()->subDays(1),
    ]);

    $animal14DaysAgo = Animal::factory()->create([
        'updated_at' => Carbon::now()->subDays(14),
    ]);

    $animalOutsideRange = Animal::factory()->create([
        'updated_at' => Carbon::now()->subDays(20),
    ]);

    $days = 17;

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get("/admin?days=$days");

    $response->assertStatus(200);

    $response->assertSee('Страница администратора');

    $responseAnimals = $response->viewData('animals');

    expect($responseAnimals->contains($animal1DayAgo))->toBeTrue();
    expect($responseAnimals->contains($animal14DaysAgo))->toBeFalse();
    expect($responseAnimals->contains($animalOutsideRange))->toBeFalse();
});
