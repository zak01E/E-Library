<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table pour le suivi de progression de lecture
        if (!Schema::hasTable('reading_progress')) {
            Schema::create('reading_progress', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('book_id');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('finished_at')->nullable();
                $table->integer('progress')->default(0);
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
                $table->index(['user_id', 'book_id']);
            });
        }
        
        // Table pour les commentaires
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('book_id');
                $table->text('comment');
                $table->boolean('is_approved')->default(false);
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
                $table->index(['book_id', 'is_approved']);
            });
        }
        
        // Table pour les évaluations
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('book_id');
                $table->integer('rating');
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
                $table->unique(['user_id', 'book_id']);
            });
        }
        
        // Ajouter les colonnes manquantes à la table books si nécessaire
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn')->nullable()->after('author_name');
            }
            if (!Schema::hasColumn('books', 'publisher')) {
                $table->string('publisher')->nullable()->after('isbn');
            }
            if (!Schema::hasColumn('books', 'publication_year')) {
                $table->integer('publication_year')->nullable()->after('publisher');
            }
            if (!Schema::hasColumn('books', 'pages')) {
                $table->integer('pages')->nullable()->after('publication_year');
            }
            if (!Schema::hasColumn('books', 'language')) {
                $table->string('language')->default('Français')->after('pages');
            }
            if (!Schema::hasColumn('books', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('category');
            }
            if (!Schema::hasColumn('books', 'tags')) {
                $table->text('tags')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('books', 'price')) {
                $table->decimal('price', 8, 2)->default(0)->after('tags');
            }
            if (!Schema::hasColumn('books', 'download_link')) {
                $table->string('download_link')->nullable()->after('price');
            }
            if (!Schema::hasColumn('books', 'preview_link')) {
                $table->string('preview_link')->nullable()->after('download_link');
            }
            if (!Schema::hasColumn('books', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            if (!Schema::hasColumn('books', 'is_recommended')) {
                $table->boolean('is_recommended')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('books', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('is_recommended');
            }
            if (!Schema::hasColumn('books', 'allow_comments')) {
                $table->boolean('allow_comments')->default(true);
            }
            if (!Schema::hasColumn('books', 'allow_ratings')) {
                $table->boolean('allow_ratings')->default(true);
            }
            if (!Schema::hasColumn('books', 'views')) {
                $table->integer('views')->default(0);
            }
            if (!Schema::hasColumn('books', 'downloads')) {
                $table->integer('downloads')->default(0);
            }
            if (!Schema::hasColumn('books', 'likes')) {
                $table->integer('likes')->default(0);
            }
            if (!Schema::hasColumn('books', 'rating')) {
                $table->decimal('rating', 2, 1)->default(0);
            }
            if (!Schema::hasColumn('books', 'uploader_id')) {
                $table->unsignedBigInteger('uploader_id')->nullable();
            }
            if (!Schema::hasColumn('books', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
            }
        });
        
        // Ajouter les colonnes manquantes à la table categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('category');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->default('fas fa-book')->after('description');
            }
            if (!Schema::hasColumn('categories', 'books_count')) {
                $table->integer('books_count')->default(0)->after('icon');
            }
            if (!Schema::hasColumn('categories', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('featured');
            }
        });
        
        // Ajouter les colonnes manquantes à la table users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('bio');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('reading_progress');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('ratings');
    }
};