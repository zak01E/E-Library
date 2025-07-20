<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('author dashboard is accessible to authors', function () {
    $author = User::factory()->create(['role' => 'auteur']);

    $response = $this->actingAs($author)->get('/author/dashboard');

    $response->assertStatus(200);
    $response->assertViewIs('author.dashboard');
});

test('author dashboard shows their statistics', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    
    Book::factory()->count(5)->create([
        'author_id' => $author->id,
        'approved' => true,
        'download_count' => 100
    ]);
    Book::factory()->count(2)->create([
        'author_id' => $author->id,
        'approved' => false
    ]);
    // Books from other authors
    Book::factory()->count(3)->create();

    $response = $this->actingAs($author)->get('/author/dashboard');

    $response->assertStatus(200);
    $response->assertViewHas('totalBooks', 7);
    $response->assertViewHas('approvedBooks', 5);
    $response->assertViewHas('totalDownloads', 500);
});

test('author can view their books', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    Book::factory()->count(5)->create(['author_id' => $author->id]);
    Book::factory()->count(3)->create(); // Other author's books

    $response = $this->actingAs($author)->get('/author/books');

    $response->assertStatus(200);
    $response->assertViewIs('author.books');
    $response->assertViewHas('books', function ($books) use ($author) {
        return $books->count() === 5 && 
               $books->every(fn($book) => $book->author_id === $author->id);
    });
});

test('author can view analytics', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    Book::factory()->count(3)->create([
        'author_id' => $author->id,
        'approved' => true
    ]);

    $response = $this->actingAs($author)->get('/author/analytics');

    $response->assertStatus(200);
    $response->assertViewIs('author.analytics');
});

test('author can edit their own books', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['author_id' => $author->id]);

    $response = $this->actingAs($author)->get("/author/books/{$book->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('author.edit-book');
    $response->assertViewHas('book');
});

test('author cannot edit other authors books', function () {
    $author1 = User::factory()->create(['role' => 'auteur']);
    $author2 = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['author_id' => $author2->id]);

    $response = $this->actingAs($author1)->get("/author/books/{$book->id}/edit");

    $response->assertStatus(403);
});

test('author can update their book details', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['author_id' => $author->id]);

    $response = $this->actingAs($author)->put("/author/books/{$book->id}", [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'category' => 'Science',
        'language' => 'en',
        'publication_year' => 2024
    ]);

    $response->assertRedirect("/author/books/{$book->id}/edit");
    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated Title'
    ]);
});

test('non-authors cannot access author dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $admin = User::factory()->create(['role' => 'admin']);

    $userResponse = $this->actingAs($user)->get('/author/dashboard');
    $adminResponse = $this->actingAs($admin)->get('/author/dashboard');

    $userResponse->assertStatus(403);
    $adminResponse->assertStatus(403);
});