<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraphs(3, true),
            'author_id' => User::factory()->author(),
            'category' => fake()->randomElement(['Fiction', 'Non-Fiction', 'Science', 'Technology', 'History', 'Biography', 'Programming']),
            'language' => fake()->randomElement(['fr', 'en', 'es', 'de', 'it']),
            'publication_year' => fake()->numberBetween(2020, 2024),
            'file_path' => 'books/' . fake()->uuid() . '.pdf',
            'file_size' => fake()->numberBetween(100000, 10000000),
            'approved' => false,
            'download_count' => 0,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approved' => true,
        ]);
    }

    public function withDownloads(int $count = null): static
    {
        return $this->state(fn (array $attributes) => [
            'download_count' => $count ?? fake()->numberBetween(1, 1000),
        ]);
    }
}