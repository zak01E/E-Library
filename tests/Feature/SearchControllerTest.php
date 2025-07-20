<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('search page is accessible', function () {
    $response = $this->actingAs($this->user)->get('/search');

    $response->assertStatus(200);
    $response->assertViewIs('search.index');
});

test('can search books by title', function () {
    Book::factory()->create(['title' => 'Laravel Testing', 'approved' => true]);
    Book::factory()->create(['title' => 'PHP Development', 'approved' => true]);
    Book::factory()->create(['title' => 'JavaScript Guide', 'approved' => true]);

    $response = $this->actingAs($this->user)->get('/search?query=Laravel');

    $response->assertStatus(200);
    $response->assertSee('Laravel Testing');
    $response->assertDontSee('PHP Development');
    $response->assertDontSee('JavaScript Guide');
});

test('can search books by author name', function () {
    $author1 = User::factory()->create(['name' => 'John Doe']);
    $author2 = User::factory()->create(['name' => 'Jane Smith']);

    Book::factory()->create(['author_id' => $author1->id, 'approved' => true]);
    Book::factory()->create(['author_id' => $author2->id, 'approved' => true]);

    $response = $this->actingAs($this->user)->get('/search?query=John');

    $response->assertStatus(200);
    $response->assertSee('John Doe');
    $response->assertDontSee('Jane Smith');
});

test('can filter books by category', function () {
    Book::factory()->create(['category' => 'Fiction', 'approved' => true]);
    Book::factory()->create(['category' => 'Non-Fiction', 'approved' => true]);
    Book::factory()->create(['category' => 'Science', 'approved' => true]);

    $response = $this->actingAs($this->user)->get('/search?category=Fiction');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 1 && $books->first()->category === 'Fiction';
    });
});

test('can filter books by language', function () {
    Book::factory()->create(['language' => 'fr', 'approved' => true]);
    Book::factory()->create(['language' => 'en', 'approved' => true]);
    Book::factory()->create(['language' => 'es', 'approved' => true]);

    $response = $this->actingAs($this->user)->get('/search?language=fr');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 1 && $books->first()->language === 'fr';
    });
});

test('can filter books by publication year', function () {
    Book::factory()->create(['publication_year' => 2022, 'approved' => true]);
    Book::factory()->create(['publication_year' => 2023, 'approved' => true]);
    Book::factory()->create(['publication_year' => 2024, 'approved' => true]);

    $response = $this->actingAs($this->user)->get('/search?year=2023');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 1 && $books->first()->publication_year === 2023;
    });
});

test('can combine multiple filters', function () {
    Book::factory()->create([
        'title' => 'Laravel Book',
        'category' => 'Programming',
        'language' => 'en',
        'publication_year' => 2023,
        'approved' => true
    ]);

    Book::factory()->create([
        'title' => 'Laravel Guide',
        'category' => 'Programming',
        'language' => 'fr',
        'publication_year' => 2023,
        'approved' => true
    ]);

    Book::factory()->create([
        'title' => 'PHP Book',
        'category' => 'Programming',
        'language' => 'en',
        'publication_year' => 2022,
        'approved' => true
    ]);

    $response = $this->actingAs($this->user)->get('/search?query=Laravel&language=en&year=2023');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 1 && 
               $books->first()->title === 'Laravel Book' &&
               $books->first()->language === 'en' &&
               $books->first()->publication_year === 2023;
    });
});

test('can sort search results', function () {
    Book::factory()->create(['title' => 'C Book', 'approved' => true, 'created_at' => now()->subDays(3)]);
    Book::factory()->create(['title' => 'A Book', 'approved' => true, 'created_at' => now()->subDays(1)]);
    Book::factory()->create(['title' => 'B Book', 'approved' => true, 'created_at' => now()->subDays(2)]);

    $response = $this->actingAs($this->user)->get('/search?sort=title_asc');

    $response->assertStatus(200);
    $response->assertSeeInOrder(['A Book', 'B Book', 'C Book']);
});

test('search only returns approved books', function () {
    Book::factory()->create(['title' => 'Approved Book', 'approved' => true]);
    Book::factory()->create(['title' => 'Unapproved Book', 'approved' => false]);

    $response = $this->actingAs($this->user)->get('/search?query=Book');

    $response->assertStatus(200);
    $response->assertSee('Approved Book');
    $response->assertDontSee('Unapproved Book');
});

test('empty search returns all approved books', function () {
    Book::factory()->count(5)->create(['approved' => true]);
    Book::factory()->count(3)->create(['approved' => false]);

    $response = $this->actingAs($this->user)->get('/search');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 5;
    });
});

test('search results are paginated', function () {
    Book::factory()->count(25)->create(['approved' => true]);

    $response = $this->actingAs($this->user)->get('/search');

    $response->assertStatus(200);
    $response->assertViewHas('books', function ($books) {
        return $books->count() === 12; // Default pagination
    });
});