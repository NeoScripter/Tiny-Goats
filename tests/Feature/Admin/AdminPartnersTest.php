<?php

use App\Models\Partner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the list of partners', function () {
    actingAsAdmin();

    Partner::factory()->count(5)->create();

    $response = $this->get(route('partners.index'));

    $response->assertStatus(200)
        ->assertViewIs('admin.partners.index')
        ->assertViewHas('partners', fn($partners) => $partners->count() === 5);

    $response->assertSee('Наши партнеры');
});

it('shows the create partner form', function () {
    actingAsAdmin();

    $response = $this->get(route('partner.create'));

    $response->assertStatus(200)
        ->assertViewIs('admin.partners.create');

    $response->assertSee('Название');
});

it('stores a new partner with an image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $response = $this->post(route('partner.store'), [
        'name' => 'Test partner name',
        'info' => 'Test info for the partner.',
        'image' => UploadedFile::fake()->image('partner.jpg'),
    ]);

    $response->assertRedirect(route('partners.index'))
        ->assertSessionHas('success', 'Партнер успешно создан!');

    $this->assertTrue(
        Partner::where('name', 'Test partner name')
            ->where('info', 'Test info for the partner.')
            ->exists()
    );

    $partner = Partner::latest()->first();

    $this->assertTrue(Storage::disk('public')->exists($partner->image));
});


it('shows a specific partner', function () {
    actingAsAdmin();

    $partner = Partner::factory()->create();

    $response = $this->get(route('partner.show', $partner));

    $response->assertStatus(200)
        ->assertViewIs('admin.partners.show')
        ->assertViewHas('partner', $partner)
        ->assertSee($partner->name)
        ->assertSee($partner->image)
        ->assertSee($partner->info);

});

it('shows the edit form for a partner', function () {
    actingAsAdmin();

    $partner = Partner::factory()->create();

    $response = $this->get(route('partner.edit', $partner));

    $response->assertStatus(200)
        ->assertViewIs('admin.partners.edit')
        ->assertViewHas('partner', $partner)
        ->assertSee($partner->info);
});

it('updates a partner', function () {
    actingAsAdmin();

    $partner = Partner::factory()->create([
        'name' => 'Old Title',
        'image' => 'partners/old_image.jpg',
    ]);

    $old_image = $partner->image;

    Storage::fake('public');
    Storage::disk('public')->put($old_image, 'dummy content');

    $new_image = UploadedFile::fake()->image('new_image.jpg');

    $response = $this->put(route('partner.update', $partner), [
        'name' => 'Updated Title',
        'info' => 'Updated content for the partner.',
        'image' => $new_image,
    ]);

    $response->assertRedirect(route('partners.index'))
        ->assertSessionHas('success', 'Партнер успешно обновлен!');

    $this->assertTrue(
        Partner::where('name', 'Updated Title')
            ->where('id', $partner->id)
            ->where('info', 'Updated content for the partner.')
            ->exists()
    );

    $partner->refresh();

    $this->assertFalse(Storage::disk('public')->exists($old_image));
    $this->assertTrue(Storage::disk('public')->exists($partner->image));
});

it('deletes a partner and removes the image', function () {
    actingAsAdmin();

    Storage::fake('public');

    $partner = Partner::factory()->create([
        'image' => 'partners/partner.jpg',
    ]);

    Storage::disk('public')->put('partners/partner.jpg', 'dummy content');

    $this->assertTrue(Storage::disk('public')->exists('partners/partner.jpg'));

    $response = $this->delete(route('partner.destroy', $partner));

    $response->assertRedirect(route('partners.index'))
        ->assertSessionHas('success', 'Партнер успешно удален!');

    $this->assertDatabaseMissing('partners', ['id' => $partner->id]);

    $this->assertFalse(Storage::disk('public')->exists($partner->image));
});

