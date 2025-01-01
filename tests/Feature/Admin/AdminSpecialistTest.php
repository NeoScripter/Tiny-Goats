<?php

use App\Models\Animal;
use App\Models\Specialist;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the list of specialists', function () {
    actingAsAdmin();

    Specialist::factory()->count(5)->create();

    $response = $this->get(route('specialists.index'));

    $response->assertStatus(200)
        ->assertViewIs('admin.specialists.index')
        ->assertViewHas('specialists', fn($specialists) => $specialists->count() === 5);

    $response->assertSee('Специалисты');
});

it('shows the create specialist form', function () {
    actingAsAdmin();

    $response = $this->get(route('specialist.create'));

    $response->assertStatus(200)
        ->assertViewIs('admin.specialists.create');

    $response->assertSee('Фамилия, имя специалиста');
});

it('stores a new specialist with an image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $response = $this->post(route('specialist.store'), [
        'name' => 'Test specialist name',
        'speciality' => 'Test speciality for the specialist.',
        'image' => UploadedFile::fake()->image('specialist.jpg'),
    ]);

    $response->assertRedirect(route('specialists.index'))
        ->assertSessionHas('success', 'Специалист успешно создан!');

    $this->assertTrue(
        Specialist::where('name', 'Test specialist name')
            ->where('speciality', 'Test speciality for the specialist.')
            ->exists()
    );

    $specialist = Specialist::latest()->first();

    $this->assertTrue(Storage::disk('public')->exists($specialist->image_path_path));
});


it('shows a specific specialist', function () {
    actingAsAdmin();

    $specialist = Specialist::factory()->create();

    $response = $this->get(route('specialist.show', $specialist));

    $response->assertStatus(200)
        ->assertViewIs('admin.specialists.show')
        ->assertViewHas('specialist', $specialist)
        ->assertSee($specialist->name)
        ->assertSee($specialist->image_path_path)
        ->assertSee($specialist->speciality);

});

it('shows the edit form for a specialist', function () {
    actingAsAdmin();

    $specialist = Specialist::factory()->create();

    $response = $this->get(route('specialist.edit', $specialist));

    $response->assertStatus(200)
        ->assertViewIs('admin.specialists.edit')
        ->assertViewHas('specialist', $specialist)
        ->assertSee($specialist->speciality);
});

it('updates a specialist', function () {
    actingAsAdmin();

    $specialist = Specialist::factory()->create([
        'name' => 'Old Title',
    ]);

    $old_image = $specialist->image_path;

    Storage::fake('public');
    $image = UploadedFile::fake()->image('new_image.jpg');

    $response = $this->put(route('specialist.update', $specialist), [
        'name' => 'Updated Title',
        'speciality' => 'Updated content for the specialist.',
        'image_path' => $image,
    ]);

    $response->assertRedirect(route('specialists.index'))
        ->assertSessionHas('success', 'Специалист успешно обновлен!');

    $this->assertTrue(
        Specialist::where('name', 'Updated Title')
            ->where('id', $specialist->id)
            ->where('speciality', 'Updated content for the specialist.')
            ->exists()
    );

    $specialist = Specialist::latest()->first();

    $this->assertFalse(Storage::disk('public')->exists($old_image));
    $this->assertTrue(Storage::disk('public')->exists($specialist->image_path));
});

it('deletes a specialist and removes the image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $specialist = Specialist::factory()->create([
        'image_path' => 'specialists/specialist.jpg',
    ]);

    Storage::disk('public')->put('specialists/specialist.jpg', 'dummy content');

    $this->assertTrue(Storage::disk('public')->exists('specialists/specialist.jpg'));

    $response = $this->delete(route('specialist.destroy', $specialist));

    $response->assertRedirect(route('specialists.index'))
        ->assertSessionHas('success', 'Специалист успешно удален!');

    $this->assertDatabaseMissing('specialist', ['id' => $specialist->id]);

    $this->assertFalse(Storage::disk('public')->exists($specialist->image_path));
});


it('correctly displays the specialists to the admin', function () {
    actingAsAdmin();

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

    $response = $this->get('/admin/specialists?name=Matilda');

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

    $response = $this->get('/admin/specialists?char=B');

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
