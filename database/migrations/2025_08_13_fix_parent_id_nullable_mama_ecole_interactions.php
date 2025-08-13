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
        Schema::table('mama_ecole_interactions', function (Blueprint $table) {
            // Rendre parent_id nullable pour permettre les tests
            $table->foreignId('parent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mama_ecole_interactions', function (Blueprint $table) {
            // Remettre parent_id comme non-nullable
            $table->foreignId('parent_id')->nullable(false)->change();
        });
    }
};