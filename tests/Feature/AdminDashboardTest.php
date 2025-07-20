<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dashboard is accessible to admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('admin.dashboard');
});

test('admin dashboard shows statistics', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    
    User::factory()->count(5)->create(['role' => 'user']);
    User::factory()->count(3)->create(['role' => 'auteur']);
    Book::factory()->count(10)->create(['approved' => true]);
    Book::factory()->count(5)->create(['approved' => false]);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertStatus(200);
    $response->assertViewHas('totalUsers', 9); // 5 users + 3 authors + 1 admin
    $response->assertViewHas('totalBooks', 15);
    $response->assertViewHas('pendingBooks', 5);
    $response->assertViewHas('totalAuthors', 3);
});

test('admin can view all users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    User::factory()->count(10)->create();

    $response = $this->actingAs($admin)->get('/admin/users');

    $response->assertStatus(200);
    $response->assertViewIs('admin.users');
    $response->assertViewHas('users');
});

test('admin can update user roles', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($admin)->patch("/admin/users/{$user->id}/role", [
        'role' => 'auteur'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'role' => 'auteur'
    ]);
});

test('admin can delete users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    $response = $this->actingAs($admin)->delete("/admin/users/{$user->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin can view all books with filters', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Book::factory()->count(5)->create(['approved' => true]);
    Book::factory()->count(3)->create(['approved' => false]);

    $response = $this->actingAs($admin)->get('/admin/books?status=pending');

    $response->assertStatus(200);
    $response->assertViewIs('admin.books');
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 3 && $books->every(fn($book) => !$book->approved);
    });
});

test('non-admin cannot access admin dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $author = User::factory()->create(['role' => 'auteur']);

    $userResponse = $this->actingAs($user)->get('/admin/dashboard');
    $authorResponse = $this->actingAs($author)->get('/admin/dashboard');

    $userResponse->assertStatus(403);
    $authorResponse->assertStatus(403);
});