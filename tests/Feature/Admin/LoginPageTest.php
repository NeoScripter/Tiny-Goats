<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

it('allows only the registered users to enter the admin dashboard', function () {

    $response = $this->get(route('admin.index'));

    $response->assertRedirect(route('login'));

    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route('admin.index'));

    $response->assertStatus(200);

    $response->assertSee('Страница администратора');

});

it('shows the login page', function () {
    $response = $this->get('/login');

    $response->assertStatus(200)
        ->assertViewIs('auth.login')
        ->assertSee('только для администраторов сайта');
});

it('authenticates valid credentials and redirects to admin', function () {

    User::factory()->create([
        'name' => 'testuser',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'name' => 'testuser',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/admin')
        ->assertSessionHas('status', 'Вход выполнен!');

    $this->assertTrue(Auth::check());
});

it('fails authentication with invalid credentials', function () {

    User::factory()->create([
        'name' => 'testuser',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'name' => 'testuser',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect()
        ->assertSessionHasErrors('name', 'Неверное имя пользователя или пароль!');

    $this->assertFalse(Auth::check());
});

it('limits login attempts and shows rate limit error', function () {

    $credentials = [
        'name' => 'testuser',
        'password' => 'wrongpassword',
    ];

    foreach (range(1, 5) as $i) {
        $this->post('/login', $credentials);
    }

    $response = $this->post('/login', $credentials);

    $response->assertRedirect()
        ->assertSessionHasErrors('name');

    $this->assertTrue(str_contains(
        session('errors')->get('name')[0],
        'Превышен лимит попыток входа'
    ));
});

it('logs out and redirects to login page', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->assertTrue(Auth::check());

    $response = $this->post('/logout');

    $response->assertRedirect('/login')
        ->assertSessionHas('status', 'Выход из аккаунта выполнен!');

    $this->assertFalse(Auth::check());
});
