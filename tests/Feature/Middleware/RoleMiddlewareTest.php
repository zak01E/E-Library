<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can access admin routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertStatus(200);
});

test('non-admin cannot access admin routes', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get('/admin/dashboard');

    $response->assertStatus(403);
});

test('author can access author routes', function () {
    $author = User::factory()->create(['role' => 'auteur']);

    $response = $this->actingAs($author)->get('/author/dashboard');

    $response->assertStatus(200);
});

test('non-author cannot access author routes', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get('/author/dashboard');

    $response->assertStatus(403);
});

test('guest cannot access protected routes', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('authenticated user can access general protected routes', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

test('multiple roles can be checked simultaneously', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $author = User::factory()->create(['role' => 'auteur']);
    $user = User::factory()->create(['role' => 'user']);

    $adminResponse = $this->actingAs($admin)->get('/books/create');
    $authorResponse = $this->actingAs($author)->get('/books/create');
    $userResponse = $this->actingAs($user)->get('/books/create');

    expect($adminResponse->status())->toBe(200);
    expect($authorResponse->status())->toBe(200);
    expect($userResponse->status())->toBe(403);
});