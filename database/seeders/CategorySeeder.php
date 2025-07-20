<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Obtenir les catégories existantes des livres
        $existingCategories = Book::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        foreach ($existingCategories as $categoryName) {
            Category::firstOrCreate([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'is_active' => true,
                'description' => "Catégorie pour les livres de type {$categoryName}"
            ]);
        }

        $this->command->info('Catégories créées: ' . Category::count());
    }
}
