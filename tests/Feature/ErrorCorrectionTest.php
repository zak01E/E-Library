<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorCorrectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_books_relation()
    {
        $user = User::factory()->create(['role' => 'author']);
        $book = Book::factory()->create(['uploaded_by' => $user->id]);

        $this->assertTrue($user->books instanceof \Illuminate\Database\Eloquent\Relations\HasMany);
        $this->assertEquals(1, $user->books()->count());
        $this->assertEquals($book->id, $user->books->first()->id);
    }

    public function test_admin_controller_uses_uploader_relation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $uploader = User::factory()->create(['role' => 'author']);
        Book::factory()->count(3)->create(['uploaded_by' => $uploader->id]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('recent_books');
    }

    public function test_author_controller_uses_correct_fields()
    {
        $author = User::factory()->create(['role' => 'author']);
        $book = Book::factory()->create([
            'uploaded_by' => $author->id,
            'author_name' => 'Test Author',
            'publication_year' => 2023
        ]);

        $this->actingAs($author)
            ->patch(route('author.books.update', $book), [
                'title' => 'Updated Title',
                'author_name' => 'Updated Author',
                'description' => 'Updated description',
                'category' => 'Updated Category',
                'language' => 'en',
                'publication_year' => 2024,
                'isbn' => '123456789'
            ])
            ->assertRedirect(route('author.books'));

        $book->refresh();
        $this->assertEquals('Updated Title', $book->title);
        $this->assertEquals('Updated Author', $book->author_name);
        $this->assertEquals(2024, $book->publication_year);
    }

    public function test_search_controller_handles_unauthenticated_users()
    {
        Book::factory()->create(['is_approved' => true]);
        Book::factory()->create(['is_approved' => false]);

        $response = $this->get(route('books.search'));
        
        $response->assertOk();
        $response->assertViewHas('books', function ($books) {
            return $books->count() === 1 && $books->first()->is_approved === true;
        });
    }

    public function test_book_controller_handles_unauthenticated_users()
    {
        Book::factory()->create(['is_approved' => true]);
        Book::factory()->create(['is_approved' => false]);

        $response = $this->get(route('books.index'));
        
        $response->assertOk();
        $response->assertViewHas('books', function ($books) {
            return $books->count() === 1 && $books->first()->is_approved === true;
        });
    }

    public function test_book_show_requires_authentication_for_unapproved_books()
    {
        $book = Book::factory()->create(['is_approved' => false]);

        $this->get(route('books.show', $book))
            ->assertNotFound();
    }

    public function test_book_download_requires_authentication_for_unapproved_books()
    {
        $book = Book::factory()->create(['is_approved' => false]);

        $this->get(route('books.download', $book))
            ->assertNotFound();
    }

    public function test_author_can_only_edit_own_books()
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $book = Book::factory()->create(['uploaded_by' => $author1->id]);

        $this->actingAs($author2)
            ->patch(route('author.books.update', $book), [
                'title' => 'Hacked Title',
                'author_name' => 'Hacker',
                'description' => 'Should not work',
                'category' => 'Hacked',
                'language' => 'en',
                'publication_year' => 2024,
                'isbn' => '123456789'
            ])
            ->assertForbidden();
    }

    public function test_author_can_only_delete_own_books()
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $book = Book::factory()->create(['uploaded_by' => $author1->id]);

        $this->actingAs($author2)
            ->delete(route('author.books.delete', $book))
            ->assertForbidden();

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}