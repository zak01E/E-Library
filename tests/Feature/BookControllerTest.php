<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});

test('authors can view book creation form', function () {
    $author = User::factory()->create(['role' => 'auteur']);

    $response = $this->actingAs($author)->get('/books/create');

    $response->assertStatus(200);
    $response->assertViewIs('books.create');
});

test('regular users cannot view book creation form', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get('/books/create');

    $response->assertStatus(403);
});

test('authors can upload books', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $file = UploadedFile::fake()->create('book.pdf', 2000, 'application/pdf');

    $response = $this->actingAs($author)->post('/books', [
        'title' => 'Test Book',
        'description' => 'Test Description',
        'category' => 'Fiction',
        'language' => 'fr',
        'publication_year' => 2023,
        'file' => $file
    ]);

    $response->assertRedirect('/books');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('books', [
        'title' => 'Test Book',
        'author_id' => $author->id,
        'approved' => false
    ]);

    Storage::disk('public')->assertExists('books/' . $file->hashName());
});

test('book upload requires valid PDF file', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $file = UploadedFile::fake()->create('book.txt', 100);

    $response = $this->actingAs($author)->post('/books', [
        'title' => 'Test Book',
        'description' => 'Test Description',
        'category' => 'Fiction',
        'language' => 'fr',
        'publication_year' => 2023,
        'file' => $file
    ]);

    $response->assertSessionHasErrors('file');
});

test('admin can approve books', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $book = Book::factory()->create(['approved' => false]);

    $response = $this->actingAs($admin)->patch("/books/{$book->id}/approve");

    $response->assertRedirect();
    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'approved' => true
    ]);
});

test('non-admin cannot approve books', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['approved' => false]);

    $response = $this->actingAs($author)->patch("/books/{$book->id}/approve");

    $response->assertStatus(403);
});

test('users can view approved books list', function () {
    $user = User::factory()->create();
    Book::factory()->count(3)->create(['approved' => true]);
    Book::factory()->count(2)->create(['approved' => false]);

    $response = $this->actingAs($user)->get('/books');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 3 && $books->every(fn($book) => $book->approved);
    });
});

test('users can download approved books', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create([
        'approved' => true,
        'file_path' => 'books/test.pdf'
    ]);

    Storage::disk('public')->put('books/test.pdf', 'PDF content');

    $response = $this->actingAs($user)->get("/books/{$book->id}/download");

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('users cannot download unapproved books', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create(['approved' => false]);

    $response = $this->actingAs($user)->get("/books/{$book->id}/download");

    $response->assertStatus(403);
});

test('authors can edit their own books', function () {
    $author = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['author_id' => $author->id]);

    $response = $this->actingAs($author)->put("/books/{$book->id}", [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'category' => 'Non-Fiction',
        'language' => 'en',
        'publication_year' => 2024
    ]);

    $response->assertRedirect("/books/{$book->id}");
    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated Title'
    ]);
});

test('authors cannot edit other authors books', function () {
    $author1 = User::factory()->create(['role' => 'auteur']);
    $author2 = User::factory()->create(['role' => 'auteur']);
    $book = Book::factory()->create(['author_id' => $author1->id]);

    $response = $this->actingAs($author2)->put("/books/{$book->id}", [
        'title' => 'Hacked Title'
    ]);

    $response->assertStatus(403);
});

test('admin can delete any book', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $book = Book::factory()->create();

    $response = $this->actingAs($admin)->delete("/books/{$book->id}");

    $response->assertRedirect('/books');
    $this->assertDatabaseMissing('books', ['id' => $book->id]);
});