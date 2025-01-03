<?php

use App\Models\Household;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the list of households', function () {
    actingAsAdmin();

    Household::factory()->count(5)->create();

    $response = $this->get(route('households.index'));

    $response->assertStatus(200)
        ->assertViewIs('admin.households.index')
        ->assertViewHas('households', fn($households) => $households->count() === 5);

    $response->assertSee('Специалисты');
});

it('shows the create household form', function () {
    actingAsAdmin();

    $response = $this->get(route('household.create'));

    $response->assertStatus(200)
        ->assertViewIs('admin.households.create');

    $response->assertSee('Фамилия, имя специалиста');
});

it('stores a new household with an image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $response = $this->post(route('household.store'), [
        'name' => 'Test household name',
        'speciality' => 'Test speciality for the household.',
        'image' => UploadedFile::fake()->image('household.jpg'),
    ]);

    $response->assertRedirect(route('households.index'))
        ->assertSessionHas('success', 'Специалист успешно создан!');

    $this->assertTrue(
        Household::where('name', 'Test household name')
            ->where('speciality', 'Test speciality for the household.')
            ->exists()
    );

    $household = Household::latest()->first();

    $this->assertTrue(Storage::disk('public')->exists($household->image));
});


it('shows a specific household', function () {
    actingAsAdmin();

    $household = Household::factory()->create();

    $response = $this->get(route('household.show', $household));

    $response->assertStatus(200)
        ->assertViewIs('admin.households.show')
        ->assertViewHas('household', $household)
        ->assertSee($household->name)
        ->assertSee($household->image)
        ->assertSee($household->speciality);

});

it('shows the edit form for a household', function () {
    actingAsAdmin();

    $household = Household::factory()->create();

    $response = $this->get(route('household.edit', $household));

    $response->assertStatus(200)
        ->assertViewIs('admin.households.edit')
        ->assertViewHas('household', $household)
        ->assertSee($household->speciality);
});

it('updates a household', function () {
    actingAsAdmin();

    $household = Household::factory()->create([
        'name' => 'Old Title',
        'image' => 'households/old_image.jpg',
    ]);

    $old_image = $household->image;

    Storage::fake('public');
    Storage::disk('public')->put($old_image, 'dummy content');

    $new_image = UploadedFile::fake()->image('new_image.jpg');

    $response = $this->put(route('household.update', $household), [
        'name' => 'Updated Title',
        'speciality' => 'Updated content for the household.',
        'image' => $new_image,
    ]);

    $response->assertRedirect(route('households.index'))
        ->assertSessionHas('success', 'Специалист успешно обновлен!');

    $this->assertTrue(
        Household::where('name', 'Updated Title')
            ->where('id', $household->id)
            ->where('speciality', 'Updated content for the household.')
            ->exists()
    );

    $household->refresh();

    $this->assertFalse(Storage::disk('public')->exists($old_image));
    $this->assertTrue(Storage::disk('public')->exists($household->image));
});

it('deletes a household and removes the image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $household = Household::factory()->create([
        'image' => 'households/household.jpg',
    ]);

    Storage::disk('public')->put('households/household.jpg', 'dummy content');

    $this->assertTrue(Storage::disk('public')->exists('households/household.jpg'));

    $response = $this->delete(route('household.destroy', $household));

    $response->assertRedirect(route('households.index'))
        ->assertSessionHas('success', 'Специалист успешно удален!');

    $this->assertDatabaseMissing('households', ['id' => $household->id]);

    $this->assertFalse(Storage::disk('public')->exists($household->image));
});


it('correctly displays the households to the admin', function () {
    actingAsAdmin();

    $names = ['Matilda', 'Bob', 'Arnak', 'Gupee', 'John'];

    for ($i = 0; $i < 5; $i++) {
        Household::factory()->create([
            'name' => $names[$i],
        ]);
    }

    $response = $this->get(route('households.index'));

    $response->assertStatus(200);

    Household::all()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->speciality);
    });

    // Make a name query

    $response = $this->get('/admin/households?name=Matilda');

    $response->assertStatus(200);

    Household::where('name', 'not like', "%Matilda%")->get()->each(function ($household) use ($response) {
        $response->assertDontSee($household->name);
        $response->assertDontSee($household->speciality);
    });

    Household::where('name', 'like', "%Matilda%")->get()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->speciality);
    });

    // Make a character query

    $response = $this->get('/admin/households?char=B');

    $response->assertStatus(200);

    Household::where('name', 'not like', "B%")->get()->each(function ($household) use ($response) {
        $response->assertDontSee($household->name);
        $response->assertDontSee($household->speciality);
    });

    Household::where('name', 'like', "B%")->get()->each(function ($household) use ($response) {
        $response->assertSee($household->name);
        $response->assertSee($household->speciality);
    });
});
