<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserLibraryController;
use App\Http\Controllers\User\UserDiscoverController;
use App\Http\Controllers\User\UserReadingRoomController;
use App\Http\Controllers\User\UserStatsController;
use App\Http\Controllers\User\UserReservationController;
use App\Http\Controllers\User\UserCollectionController;
use App\Http\Controllers\User\UserHelpController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\UserProfileController;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
| Routes pour l'espace utilisateur standard
|
*/

Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/widgets', [UserDashboardController::class, 'widgets'])->name('dashboard.widgets');
    
    // Library Management
    Route::prefix('library')->name('library.')->group(function () {
        Route::get('/current', [UserLibraryController::class, 'current'])->name('current');
        Route::get('/history', [UserLibraryController::class, 'history'])->name('history');
        Route::get('/favorites', [UserLibraryController::class, 'favorites'])->name('favorites');
        Route::get('/wishlist', [UserLibraryController::class, 'wishlist'])->name('wishlist');
        Route::get('/reading', [UserLibraryController::class, 'reading'])->name('reading');
        
        // AJAX actions
        Route::post('/borrow', [UserLibraryController::class, 'borrowBook'])->name('borrow');
        Route::post('/return', [UserLibraryController::class, 'returnBook'])->name('return');
        Route::post('/extend', [UserLibraryController::class, 'extendBorrowing'])->name('extend');
        Route::post('/favorite/add', [UserLibraryController::class, 'addToFavorites'])->name('favorite.add');
        Route::post('/favorite/remove', [UserLibraryController::class, 'removeFromFavorites'])->name('favorite.remove');
        Route::post('/wishlist/add', [UserLibraryController::class, 'addToWishlist'])->name('wishlist.add');
        Route::post('/wishlist/remove', [UserLibraryController::class, 'removeFromWishlist'])->name('wishlist.remove');
        Route::post('/wishlist/update-priority', [UserLibraryController::class, 'updateWishlistPriority'])->name('wishlist.priority');
    });
    
    // Discover & Browse
    Route::prefix('discover')->name('discover.')->group(function () {
        Route::get('/', [UserDiscoverController::class, 'index'])->name('index');
        Route::get('/new', [UserDiscoverController::class, 'new'])->name('new');
        Route::get('/popular', [UserDiscoverController::class, 'popular'])->name('popular');
        Route::get('/trending', [UserDiscoverController::class, 'trending'])->name('trending');
        Route::get('/recommendations', [UserDiscoverController::class, 'recommendations'])->name('recommendations');
        Route::get('/categories', [UserDiscoverController::class, 'categories'])->name('categories');
        Route::get('/categories/{slug}', [UserDiscoverController::class, 'categoryBooks'])->name('category');
        Route::get('/authors', [UserDiscoverController::class, 'authors'])->name('authors');
        Route::get('/authors/{id}', [UserDiscoverController::class, 'authorBooks'])->name('author');
        Route::get('/search', [UserDiscoverController::class, 'search'])->name('search');
        Route::get('/advanced-search', [UserDiscoverController::class, 'advancedSearch'])->name('advanced-search');
        Route::get('/book/{id}/quick-view', [UserDiscoverController::class, 'quickView'])->name('quick-view');
    });
    
    // Reading Room
    Route::prefix('reading-room')->name('reading-room.')->group(function () {
        Route::get('/', [UserReadingRoomController::class, 'index'])->name('index');
        Route::get('/book/{id}', [UserReadingRoomController::class, 'read'])->name('read');
        Route::get('/current', [UserReadingRoomController::class, 'current'])->name('current');
        Route::get('/bookmarks', [UserReadingRoomController::class, 'bookmarks'])->name('bookmarks');
        Route::get('/notes', [UserReadingRoomController::class, 'notes'])->name('notes');
        Route::get('/highlights', [UserReadingRoomController::class, 'highlights'])->name('highlights');
        
        // Reading session actions
        Route::post('/session/start', [UserReadingRoomController::class, 'startSession'])->name('session.start');
        Route::post('/session/end', [UserReadingRoomController::class, 'endSession'])->name('session.end');
        Route::post('/session/update', [UserReadingRoomController::class, 'updateProgress'])->name('session.update');
        Route::post('/bookmark/add', [UserReadingRoomController::class, 'addBookmark'])->name('bookmark.add');
        Route::post('/bookmark/remove', [UserReadingRoomController::class, 'removeBookmark'])->name('bookmark.remove');
        Route::post('/note/add', [UserReadingRoomController::class, 'addNote'])->name('note.add');
        Route::post('/note/update', [UserReadingRoomController::class, 'updateNote'])->name('note.update');
        Route::post('/note/delete', [UserReadingRoomController::class, 'deleteNote'])->name('note.delete');
        Route::post('/highlight/add', [UserReadingRoomController::class, 'addHighlight'])->name('highlight.add');
        Route::post('/highlight/remove', [UserReadingRoomController::class, 'removeHighlight'])->name('highlight.remove');
    });
    
    // Statistics & Progress
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', [UserStatsController::class, 'index'])->name('index');
        Route::get('/reading-time', [UserStatsController::class, 'readingTime'])->name('reading-time');
        Route::get('/books-read', [UserStatsController::class, 'booksRead'])->name('books-read');
        Route::get('/genres', [UserStatsController::class, 'genreAnalysis'])->name('genres');
        Route::get('/achievements', [UserStatsController::class, 'achievements'])->name('achievements');
        Route::get('/goals', [UserStatsController::class, 'readingGoals'])->name('goals');
        Route::post('/goals/set', [UserStatsController::class, 'setGoal'])->name('goals.set');
        Route::get('/export', [UserStatsController::class, 'exportStats'])->name('export');
    });
    
    // Reservations
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [UserReservationController::class, 'index'])->name('index');
        Route::get('/active', [UserReservationController::class, 'active'])->name('active');
        Route::get('/history', [UserReservationController::class, 'history'])->name('history');
        Route::post('/create', [UserReservationController::class, 'create'])->name('create');
        Route::post('/cancel', [UserReservationController::class, 'cancel'])->name('cancel');
        Route::post('/confirm', [UserReservationController::class, 'confirm'])->name('confirm');
        Route::get('/check-availability', [UserReservationController::class, 'checkAvailability'])->name('check');
    });
    
    // Collections
    Route::prefix('collections')->name('collections.')->group(function () {
        Route::get('/', [UserCollectionController::class, 'index'])->name('index');
        Route::get('/my-collections', [UserCollectionController::class, 'myCollections'])->name('my');
        Route::get('/public', [UserCollectionController::class, 'publicCollections'])->name('public');
        Route::get('/following', [UserCollectionController::class, 'following'])->name('following');
        Route::get('/{id}', [UserCollectionController::class, 'show'])->name('show');
        Route::post('/create', [UserCollectionController::class, 'create'])->name('create');
        Route::post('/{id}/update', [UserCollectionController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserCollectionController::class, 'delete'])->name('delete');
        Route::post('/{id}/add-book', [UserCollectionController::class, 'addBook'])->name('add-book');
        Route::post('/{id}/remove-book', [UserCollectionController::class, 'removeBook'])->name('remove-book');
        Route::post('/{id}/follow', [UserCollectionController::class, 'follow'])->name('follow');
        Route::post('/{id}/unfollow', [UserCollectionController::class, 'unfollow'])->name('unfollow');
        Route::post('/{id}/share', [UserCollectionController::class, 'share'])->name('share');
    });
    
    // Help & Support
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/', [UserHelpController::class, 'index'])->name('index');
        Route::get('/faq', [UserHelpController::class, 'faq'])->name('faq');
        Route::get('/guide', [UserHelpController::class, 'guide'])->name('guide');
        Route::get('/tutorials', [UserHelpController::class, 'tutorials'])->name('tutorials');
        Route::get('/contact', [UserHelpController::class, 'contact'])->name('contact');
        Route::post('/contact', [UserHelpController::class, 'sendContact'])->name('contact.send');
        Route::get('/ticket/{id}', [UserHelpController::class, 'viewTicket'])->name('ticket.view');
        Route::post('/ticket/create', [UserHelpController::class, 'createTicket'])->name('ticket.create');
        Route::post('/ticket/{id}/reply', [UserHelpController::class, 'replyTicket'])->name('ticket.reply');
        Route::get('/search', [UserHelpController::class, 'searchHelp'])->name('search');
    });
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [UserNotificationController::class, 'index'])->name('index');
        Route::get('/unread', [UserNotificationController::class, 'unread'])->name('unread');
        Route::post('/mark-read', [UserNotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [UserNotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [UserNotificationController::class, 'delete'])->name('delete');
        Route::post('/settings', [UserNotificationController::class, 'updateSettings'])->name('settings');
    });
    
    // Profile & Settings
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [UserProfileController::class, 'update'])->name('update');
        Route::post('/avatar', [UserProfileController::class, 'updateAvatar'])->name('avatar');
        Route::delete('/avatar', [UserProfileController::class, 'deleteAvatar'])->name('avatar.delete');
        Route::get('/privacy', [UserProfileController::class, 'privacy'])->name('privacy');
        Route::post('/privacy', [UserProfileController::class, 'updatePrivacy'])->name('privacy.update');
        Route::get('/preferences', [UserProfileController::class, 'preferences'])->name('preferences');
        Route::post('/preferences', [UserProfileController::class, 'updatePreferences'])->name('preferences.update');
        Route::get('/subscription', [UserProfileController::class, 'subscription'])->name('subscription');
        Route::post('/subscription/upgrade', [UserProfileController::class, 'upgradeSubscription'])->name('subscription.upgrade');
        Route::post('/subscription/cancel', [UserProfileController::class, 'cancelSubscription'])->name('subscription.cancel');
        Route::get('/security', [UserProfileController::class, 'security'])->name('security');
        Route::post('/security/2fa', [UserProfileController::class, 'enable2FA'])->name('2fa.enable');
        Route::delete('/security/2fa', [UserProfileController::class, 'disable2FA'])->name('2fa.disable');
        Route::post('/security/password', [UserProfileController::class, 'updatePassword'])->name('password.update');
    });
    
    // Reviews & Ratings
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/my-reviews', [UserReviewController::class, 'myReviews'])->name('my');
        Route::post('/create', [UserReviewController::class, 'create'])->name('create');
        Route::patch('/{id}', [UserReviewController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserReviewController::class, 'delete'])->name('delete');
        Route::post('/{id}/helpful', [UserReviewController::class, 'markHelpful'])->name('helpful');
        Route::post('/{id}/report', [UserReviewController::class, 'report'])->name('report');
    });
    
    // Social Features
    Route::prefix('social')->name('social.')->group(function () {
        Route::get('/friends', [UserSocialController::class, 'friends'])->name('friends');
        Route::get('/reading-clubs', [UserSocialController::class, 'readingClubs'])->name('clubs');
        Route::get('/challenges', [UserSocialController::class, 'challenges'])->name('challenges');
        Route::post('/share-progress', [UserSocialController::class, 'shareProgress'])->name('share');
        Route::post('/friend-request', [UserSocialController::class, 'sendFriendRequest'])->name('friend.request');
        Route::post('/friend-accept', [UserSocialController::class, 'acceptFriend'])->name('friend.accept');
    });
});