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
        Schema::table('books', function (Blueprint $table) {
            $table->string('visibility')->default('public')->after('is_approved');
            $table->index('visibility');
        });

        // Mettre à jour tous les livres existants approuvés pour qu'ils soient publics
        \DB::table('books')
            ->where('is_approved', true)
            ->update(['visibility' => 'public']);

        // Mettre à jour les livres non approuvés pour qu'ils soient privés
        \DB::table('books')
            ->where('is_approved', false)
            ->update(['visibility' => 'private']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['visibility']);
            $table->dropColumn('visibility');
        });
    }
};