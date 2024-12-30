<?php

use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function actingAsAdmin()
{
    $user = User::factory()->create();
    test()->actingAs($user);
}

it('shows the list of animals for sale', function () {
    actingAsAdmin();

    $forSaleAnimals = Animal::factory()->count(3)->create(['forSale' => true]);
    $notForSaleAnimals = Animal::factory()->count(2)->create(['forSale' => false]);

    $response = $this->get(route('animals.index.sale'));

    $response->assertStatus(200)
        ->assertViewIs('admin.animals.sale')
        ->assertViewHas('animals');

    $forSaleAnimals->each(fn($animal) => $response->assertSee($animal->name));
    $notForSaleAnimals->each(fn($animal) => $response->assertDontSee($animal->name));
});

it('shows the create animal form', function () {
    actingAsAdmin();

    $response = $this->get(route('animals.create'));

    $response->assertStatus(200)
        ->assertViewIs('admin.animals.create')
        ->assertViewHas('maleAnimals')
        ->assertViewHas('femaleAnimals')
        ->assertViewHas('allAnimals');
});

it('stores a new animal with images', function () {
    actingAsAdmin();

    Storage::fake('public');

    $response = $this->post(route('animals.store'), [
        'name' => 'Test Animal',
        'isMale' => true,
        'breed' => 'Test Breed',
        'images' => [
            UploadedFile::fake()->image('image1.jpg'),
            UploadedFile::fake()->image('image2.jpg'),
        ],
    ]);

    $response->assertRedirect(route('animals.index'))
        ->assertSessionHas('success', 'Животное успешно добавлено!');

    $animal = Animal::first();

    $this->assertDatabaseHas('animals', [
        'name' => 'Test Animal',
        'breed' => 'Test Breed',
    ]);

    $this->assertCount(2, $animal->images);

    $this->assertTrue(Storage::disk('public')->exists($animal->images[0]));
    $this->assertTrue(Storage::disk('public')->exists($animal->images[1]));
});

it('shows the edit animal form', function () {
    actingAsAdmin();

    $animal = Animal::factory()->create();

    $response = $this->get(route('animals.edit', $animal));

    $response->assertStatus(200)
        ->assertViewIs('admin.animals.edit')
        ->assertViewHas('animal', $animal)
        ->assertViewHas('maleAnimals')
        ->assertViewHas('femaleAnimals')
        ->assertViewHas('allAnimals');
});

it('updates an animal with new images', function () {
    actingAsAdmin();

    Storage::fake('public');

    $animal = Animal::factory()->create([
        'name' => 'Old Name',
        'images' => ['animals_images/old_image.jpg'],
    ]);

    $old_img = $animal->images[0];

    Storage::disk('public')->put('animals_images/old_image.jpg', 'dummy content');

    $response = $this->put(route('animals.update', $animal), [
        'name' => 'Updated Name',
        'isMale' => $animal->isMale,
        'breed' => 'Updated Breed',
        'images' => [
            UploadedFile::fake()->image('new_image1.jpg'),
            UploadedFile::fake()->image('new_image2.jpg'),
        ],
    ]);

    $response->assertRedirect(route('animals.index'))
        ->assertSessionHas('success', 'Животное успешно обновлено!');

    $animal->refresh();

    $this->assertDatabaseHas('animals', [
        'id' => $animal->id,
        'name' => 'Updated Name',
        'breed' => 'Updated Breed',
    ]);

    $this->assertTrue(Storage::disk('public')->exists($old_img));
    $this->assertTrue(Storage::disk('public')->exists($animal->images[0]));
    $this->assertTrue(Storage::disk('public')->exists($animal->images[1]));
});

it('deletes an animal and its images', function () {
    actingAsAdmin();

    Storage::fake('public');

    $animal = Animal::factory()->create([
        'images' => [
            'animals_images/image1.jpg',
            'animals_images/image2.jpg',
        ],
    ]);

    $old_images = $animal->images;

    Storage::disk('public')->put('animals_images/image1.jpg', 'dummy content');
    Storage::disk('public')->put('animals_images/image2.jpg', 'dummy content');

    $response = $this->delete(route('animals.destroy', $animal));

    $response->assertRedirect(route('animals.index'))
        ->assertSessionHas('success', 'Животное успешно удалено!');

    $this->assertDatabaseMissing('animals', ['id' => $animal->id]);

    foreach($old_images as $img) {
        $this->assertFalse(Storage::disk('public')->exists($img));
    }
});
