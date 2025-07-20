<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect('/profile');

    $user->refresh();

    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Test User',
        'email' => $user->email,
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect('/profile');

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->delete('/profile', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->delete('/profile', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('password');
    $response->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('profile update requires valid email', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->patch('/profile', [
        'name' => 'Test User',
        'email' => 'invalid-email',
    ]);

    $response->assertSessionHasErrors('email');
});

test('profile update with existing email fails', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $response = $this->actingAs($user1)->patch('/profile', [
        'name' => 'Test User',
        'email' => $user2->email,
    ]);

    $response->assertSessionHasErrors('email');
});

test('profile shows user role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $author = User::factory()->create(['role' => 'auteur']);
    $user = User::factory()->create(['role' => 'user']);

    $adminResponse = $this->actingAs($admin)->get('/profile');
    $authorResponse = $this->actingAs($author)->get('/profile');
    $userResponse = $this->actingAs($user)->get('/profile');

    $adminResponse->assertSee('Administrateur');
    $authorResponse->assertSee('Auteur');
    $userResponse->assertSee('Utilisateur');
});