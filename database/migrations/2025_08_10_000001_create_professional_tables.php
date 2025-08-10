<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Profiles table
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('display_name')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('language_preference')->default('fr');
            $table->string('timezone')->default('Europe/Paris');
            $table->json('reading_preferences')->nullable();
            $table->json('privacy_settings')->nullable();
            $table->json('notification_settings')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
        });

        // Authors enhanced table
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pen_name')->nullable();
            $table->text('biography')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('verification_documents')->nullable();
            $table->integer('total_books')->default(0);
            $table->integer('total_downloads')->default(0);
            $table->decimal('total_revenue', 10, 2)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(70.00);
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            $table->enum('author_level', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
            $table->json('achievements')->nullable();
            $table->json('specializations')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('verification_status');
        });

        // Book authors relationship
        Schema::create('book_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->enum('contribution_type', ['author', 'co-author', 'editor', 'translator'])->default('author');
            $table->decimal('contribution_percentage', 5, 2)->default(100.00);
            $table->integer('position')->default(1);
            $table->timestamps();
            
            $table->unique(['book_id', 'author_id']);
            $table->index('book_id');
            $table->index('author_id');
        });

        // Borrowings table
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('borrowed_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->integer('extended_count')->default(0);
            $table->enum('status', ['active', 'returned', 'overdue', 'lost'])->default('active');
            $table->decimal('fine_amount', 8, 2)->default(0);
            $table->boolean('fine_paid')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('due_date');
        });

        // Reservations table
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'expired'])->default('pending');
            $table->boolean('notification_sent')->default(false);
            $table->integer('priority')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('expires_at');
        });

        // Reading sessions table
        Schema::create('reading_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->integer('pages_read')->default(0);
            $table->integer('current_page')->default(0);
            $table->decimal('current_position', 5, 2)->default(0);
            $table->string('device_type')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'book_id']);
            $table->index('started_at');
        });

        // Reviews table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_verified_purchase')->default(false);
            $table->integer('helpful_count')->default(0);
            $table->integer('unhelpful_count')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('moderation_notes')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']);
            $table->index(['book_id', 'status']);
            $table->index('rating');
        });

        // Collections table
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('follower_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'is_public']);
            $table->index('slug');
        });

        // Collection books relationship
        Schema::create('collection_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('position')->default(0);
            $table->timestamp('added_at')->nullable();
            $table->text('notes')->nullable();
            
            $table->unique(['collection_id', 'book_id']);
            $table->index('collection_id');
            $table->index('book_id');
        });

        // Transactions table
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['purchase', 'subscription', 'fine', 'refund']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('EUR');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('invoice_number')->unique()->nullable();
            $table->string('invoice_path')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('invoice_number');
            $table->index('created_at');
        });

        // Analytics events table
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('session_id');
            $table->string('event_type');
            $table->string('event_category');
            $table->string('event_action');
            $table->string('event_label')->nullable();
            $table->string('event_value')->nullable();
            $table->string('page_url')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('device_type')->nullable();
            $table->string('os')->nullable();
            $table->string('browser')->nullable();
            $table->timestamp('created_at')->nullable();
            
            $table->index(['user_id', 'event_type']);
            $table->index('session_id');
            $table->index('created_at');
        });

        // Notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('title');
            $table->text('content');
            $table->string('action_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });

        // Book categories relationship
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
            $table->unique(['book_id', 'category_id']);
            $table->index('book_id');
            $table->index('category_id');
        });

        // User favorites
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']);
            $table->index('user_id');
            $table->index('book_id');
        });

        // User reading list (wishlist)
        Schema::create('user_reading_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('priority')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']);
            $table->index(['user_id', 'priority']);
        });

        // Enhance existing users table
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
            $table->string('username')->after('email')->unique()->nullable();
            $table->enum('status', ['active', 'suspended', 'banned', 'pending'])->default('active')->after('role');
            $table->enum('subscription_type', ['free', 'basic', 'premium', 'enterprise'])->default('free')->after('status');
            $table->timestamp('subscription_expires_at')->nullable()->after('subscription_type');
            $table->timestamp('last_login_at')->nullable();
            $table->integer('login_count')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->json('preferences')->nullable();
            $table->softDeletes();
            
            $table->index('username');
            $table->index('status');
            $table->index('subscription_type');
        });

        // Enhance existing books table
        Schema::table('books', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->unique()->nullable();
            $table->string('slug')->after('title')->unique()->nullable();
            $table->string('isbn13')->after('isbn')->nullable();
            $table->text('summary')->after('description')->nullable();
            $table->string('original_language')->after('language')->nullable();
            $table->date('publication_date')->after('publication_year')->nullable();
            $table->foreignId('publisher_id')->nullable()->after('publisher');
            $table->string('edition')->nullable()->after('publisher_id');
            $table->string('volume')->nullable()->after('edition');
            $table->enum('format', ['pdf', 'epub', 'mobi', 'azw3'])->default('pdf')->after('pages');
            $table->bigInteger('file_size')->nullable()->after('format');
            $table->string('preview_file')->nullable()->after('cover_image');
            $table->decimal('price', 8, 2)->default(0)->after('preview_file');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('price');
            $table->enum('visibility', ['public', 'private', 'restricted'])->default('public')->after('status');
            $table->boolean('drm_protected')->default(false)->after('visibility');
            $table->integer('download_count')->default(0)->after('downloads');
            $table->integer('view_count')->default(0)->after('views');
            $table->decimal('rating_average', 3, 2)->default(0)->after('view_count');
            $table->integer('rating_count')->default(0)->after('rating_average');
            $table->boolean('featured')->default(false)->after('rating_count');
            $table->timestamp('featured_until')->nullable()->after('featured');
            $table->json('metadata')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index('isbn13');
            $table->index('status');
            $table->index('visibility');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        // Drop foreign key constraints and tables in reverse order
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'uuid', 'slug', 'isbn13', 'summary', 'original_language',
                'publication_date', 'publisher_id', 'edition', 'volume',
                'format', 'file_size', 'preview_file', 'price',
                'discount_percentage', 'visibility', 'drm_protected',
                'download_count', 'view_count', 'rating_average',
                'rating_count', 'featured', 'featured_until',
                'metadata', 'published_at', 'deleted_at'
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid', 'username', 'status', 'subscription_type',
                'subscription_expires_at', 'last_login_at', 'login_count',
                'ip_address', 'user_agent', 'two_factor_enabled',
                'two_factor_secret', 'phone', 'phone_verified_at',
                'preferences', 'deleted_at'
            ]);
        });

        Schema::dropIfExists('user_reading_lists');
        Schema::dropIfExists('user_favorites');
        Schema::dropIfExists('book_categories');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('collection_books');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('reading_sessions');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('book_authors');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('profiles');
    }
};