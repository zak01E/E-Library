<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('author_name');
            $table->string('isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('category')->nullable();
            $table->string('language')->default('fr');
            $table->integer('pages')->nullable();
            $table->string('pdf_path');
            $table->string('cover_image')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('title');
            $table->index('author_name');
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};