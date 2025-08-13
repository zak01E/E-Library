<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('position')->default(0)->after('slug');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->index('position');
            $table->index('is_featured');
        });

        // Définir des positions par défaut pour les catégories existantes
        $categories = \DB::table('categories')->orderBy('name')->get();
        $position = 1;
        foreach ($categories as $category) {
            \DB::table('categories')
                ->where('id', $category->id)
                ->update(['position' => $position++]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['position']);
            $table->dropIndex(['is_featured']);
            $table->dropColumn('position');
            $table->dropColumn('is_featured');
        });
    }
};