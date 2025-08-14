<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/trending-data', [App\Http\Controllers\HomeController::class, 'getTrendingData'])->name('home.trending');

// Educational News Routes
Route::prefix('actualites')->name('news.')->group(function () {
    Route::get('/', [App\Http\Controllers\NewsController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('show');
    Route::get('/api/widget', [App\Http\Controllers\NewsController::class, 'widget'])->name('widget');
    Route::get('/api/ticker', [App\Http\Controllers\NewsController::class, 'ticker'])->name('ticker');
});

// School Calendar Routes
Route::prefix('calendrier')->name('calendar.')->group(function () {
    Route::get('/', [App\Http\Controllers\CalendarController::class, 'index'])->name('index');
    Route::get('/evenement/{id}', [App\Http\Controllers\CalendarController::class, 'showEvent'])->name('event');
    Route::get('/api/events', [App\Http\Controllers\CalendarController::class, 'events'])->name('events');
    Route::get('/api/widget', [App\Http\Controllers\CalendarController::class, 'widget'])->name('widget');
    Route::get('/api/important-dates', [App\Http\Controllers\CalendarController::class, 'importantDates'])->name('important-dates');
    Route::get('/export/ics', [App\Http\Controllers\CalendarController::class, 'export'])->name('export');
});

// Mentorship Routes
Route::prefix('parrainage')->name('mentorship.')->group(function () {
    Route::get('/', [App\Http\Controllers\MentorshipController::class, 'index'])->name('index');
    Route::get('/mentors', [App\Http\Controllers\MentorshipController::class, 'browseMentors'])->name('browse');
    Route::get('/mentor/{id}', [App\Http\Controllers\MentorshipController::class, 'showMentor'])->name('mentor.show');
    
    // Protected routes (require authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/devenir-mentor', [App\Http\Controllers\MentorshipController::class, 'becomeMentor'])->name('become');
        Route::post('/devenir-mentor', [App\Http\Controllers\MentorshipController::class, 'storeMentorApplication'])->name('apply');
        Route::post('/mentor/{id}/demande', [App\Http\Controllers\MentorshipController::class, 'requestMentorship'])->name('request');
    });
});

// MAMA ÉCOLE Routes - Système d'inclusion des parents illettrés
Route::prefix('mama-ecole')->name('mama-ecole.')->group(function () {
    // Public routes
    Route::get('/', [App\Http\Controllers\MamaEcoleController::class, 'index'])->name('index');
    // Route::get('/demo', [App\Http\Controllers\MamaEcoleController::class, 'demo'])->name('demo'); // Page demo supprimée - non pertinente
    Route::get('/info', [App\Http\Controllers\MamaEcoleController::class, 'info'])->name('info');
    
    // Webhook routes for Twilio/Orange
    Route::post('/webhook/voice', [App\Http\Controllers\MamaEcoleController::class, 'handleCallback'])->name('callback');
    Route::post('/webhook/twiml/{id}', [App\Http\Controllers\MamaEcoleController::class, 'generateTwiml'])->name('twiml');
    Route::post('/webhook/input', [App\Http\Controllers\MamaEcoleController::class, 'handleInput'])->name('handle-input');
    Route::post('/webhook/recording', [App\Http\Controllers\MamaEcoleController::class, 'handleRecording'])->name('handle-recording');
    
    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\MamaEcoleController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [App\Http\Controllers\MamaEcoleController::class, 'analytics'])->name('analytics');
        Route::get('/parents', [App\Http\Controllers\MamaEcoleController::class, 'parents'])->name('parents');
        Route::post('/notify', [App\Http\Controllers\MamaEcoleController::class, 'sendNotification'])->name('notify');
        Route::post('/configure-parent', [App\Http\Controllers\MamaEcoleController::class, 'configureParent'])->name('configure-parent');
        Route::get('/templates', [App\Http\Controllers\MamaEcoleController::class, 'templates'])->name('templates');
        Route::get('/campaigns', [App\Http\Controllers\MamaEcoleController::class, 'campaigns'])->name('campaigns');
    });
    
    // Routes Orange CI SMS
    Route::post('/sms/send', [App\Http\Controllers\MamaEcoleController::class, 'sendSMS'])->name('sms.send');
    Route::post('/sms/callback', [App\Http\Controllers\MamaEcoleController::class, 'smsCallback'])->name('sms-callback');
    Route::post('/sms/incoming', [App\Http\Controllers\MamaEcoleController::class, 'handleIncomingSMS'])->name('sms.incoming');
    Route::post('/ussd/handle', [App\Http\Controllers\MamaEcoleController::class, 'handleUSSD'])->name('ussd.handle');
    
    // Routes de test Twilio
    Route::get('/test-twilio', [App\Http\Controllers\MamaEcoleController::class, 'testTwilio'])->name('test.twilio');
    Route::post('/test/call', [App\Http\Controllers\MamaEcoleController::class, 'testCall'])->name('test.call');
    Route::post('/test/sms', [App\Http\Controllers\MamaEcoleController::class, 'testSMS'])->name('test.sms');
    
    // Routes de test simple (qui fonctionne vraiment)
    Route::get('/test-simple', [App\Http\Controllers\MamaEcoleController::class, 'testSimple'])->name('test.simple');
    Route::post('/test-simple', [App\Http\Controllers\MamaEcoleController::class, 'testSMSSimple'])->name('test.sms.simple');
    
    // Routes de test d'appel
    Route::get('/test-appel', [App\Http\Controllers\MamaEcoleController::class, 'testAppel'])->name('test.appel');
    Route::post('/test-appel', [App\Http\Controllers\MamaEcoleController::class, 'testCallSimple'])->name('test.call.simple');
});

// API routes pour les fonctionnalités avancées
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/search-suggestions', [App\Http\Controllers\HomeController::class, 'getSearchSuggestions'])->name('search.suggestions');
    Route::get('/search/suggestions', [App\Http\Controllers\Api\SearchController::class, 'suggestions'])->name('search.suggestions.advanced');
    Route::get('/search/advanced', [App\Http\Controllers\Api\SearchController::class, 'advanced'])->name('search.advanced');
    Route::get('/search/autocomplete', [App\Http\Controllers\Api\SearchController::class, 'autocomplete'])->name('search.autocomplete');
});

// Design showcase route (for development/demo purposes)
Route::get('/design-showcase', function () {
    return view('design-showcase');
})->name('design.showcase');

Route::get('/search', [SearchController::class, 'index'])->name('books.search');

// Public book routes (accessible without authentication)
// Redirect /library to /search for consistency
Route::get('/library', function (Illuminate\Http\Request $request) {
    return redirect()->route('books.search', $request->all());
})->name('books.public.index');
Route::get('/library/{book}', [BookController::class, 'publicShow'])->name('books.public.show');
Route::get('/library/{book}/preview', [BookController::class, 'preview'])->name('books.public.preview');

// Public author routes (accessible without authentication)
Route::get('/authors', [App\Http\Controllers\PublicAuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [App\Http\Controllers\PublicAuthorController::class, 'show'])->name('authors.show');

// Protected download route (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/library/{book}/download', [BookController::class, 'download'])->name('books.public.download');
    
    // Admin book approval route (accessible from public book listings)
    Route::middleware('is-admin')->group(function () {
        Route::patch('/books/{book}/approve', [App\Http\Controllers\AdminController::class, 'approveBook'])->name('books.approve');
    });
});

// Admin login route
Route::middleware(['guest', 'admin.guest'])->group(function () {
    Route::get('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [App\Http\Controllers\Auth\AdminAuthController::class, 'store'])->name('admin.login.submit');
});

// Admin logout route
Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminAuthController::class, 'destroy'])->name('admin.logout');

    // Route de test pour déconnexion (TEMPORAIRE)
    Route::get('/admin/test-logout', function() {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('success', 'Déconnexion test réussie!');
    })->name('admin.test.logout');
});

// Route de déconnexion simple sans middleware (TEMPORAIRE)
Route::get('/admin/simple-logout', function() {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/admin/login')->with('success', 'Déconnexion simple réussie!');
})->name('admin.simple.logout');

// Routes de test pour les paramètres (TEMPORAIRE)
Route::get('/admin/test-settings-update', function() {
    // Simuler une mise à jour des paramètres
    \App\Models\SiteSetting::set('site_name', 'E-Library Test');
    \App\Models\SiteSetting::set('site_description', 'Test de mise à jour');

    return redirect()->route('admin.settings')->with('success', 'Test de mise à jour réussi!');
})->name('admin.test.settings.update');



// Route de test pour connexion directe (TEMPORAIRE)
Route::get('/admin/test-login', function() {
    $admin = \App\Models\User::where('email', 'admin@elibrary.com')->first();

    if (!$admin) {
        return response()->json(['error' => 'Admin user not found'], 404);
    }

    // Connecter directement l'admin
    \Illuminate\Support\Facades\Auth::login($admin);

    return redirect()->route('admin.dashboard')->with('success', 'Connexion test réussie!');
})->name('admin.test.login');

// Route de diagnostic (TEMPORAIRE)
Route::get('/admin/diagnostic', function() {
    $admin = \App\Models\User::where('email', 'admin@elibrary.com')->first();

    $data = [
        'admin_exists' => $admin ? true : false,
        'admin_data' => $admin ? [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => $admin->role,
            'email_verified' => $admin->email_verified_at ? true : false
        ] : null,
        'password_check' => $admin ? \Illuminate\Support\Facades\Hash::check('password', $admin->password) : false,
        'session_config' => [
            'driver' => config('session.driver'),
            'cookie' => config('session.cookie'),
            'domain' => config('session.domain'),
            'secure' => config('session.secure'),
            'http_only' => config('session.http_only'),
            'same_site' => config('session.same_site')
        ],
        'current_user' => \Illuminate\Support\Facades\Auth::user(),
        'routes' => [
            'admin.login' => route('admin.login'),
            'admin.dashboard' => route('admin.dashboard')
        ]
    ];

    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
})->name('admin.diagnostic');

// Route de connexion simple intégrée (TEMPORAIRE)
Route::get('/admin/simple-login', function() {
    return view('admin.simple-login');
})->name('admin.simple.login');

Route::post('/admin/simple-login', function(\Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Connexion réussie!');
        } else {
            \Illuminate\Support\Facades\Auth::logout();
            return back()->withErrors(['email' => 'Accès réservé aux administrateurs.']);
        }
    }

    return back()->withErrors(['email' => 'Identifiants incorrects.']);
})->name('admin.simple.login.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('ensure-correct-dashboard')
        ->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile photo routes
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');

    // Books routes
    Route::resource('books', BookController::class);
    Route::get('books/{book}/download', [BookController::class, 'download'])->name('books.download');
    Route::get('books/categories', [MainDashboardController::class, 'booksCategories'])->name('books.categories');
    Route::get('books/reviews', [MainDashboardController::class, 'booksReviews'])->name('books.reviews');

    // Main Dashboard
    Route::get('/main-dashboard', [MainDashboardController::class, 'index'])->name('main.dashboard');

    // Collections routes
    Route::get('collections', [MainDashboardController::class, 'collectionsIndex'])->name('collections.index');
    Route::get('collections/featured', function() { return view('collections.featured'); })->name('collections.featured');
    Route::get('collections/create', function() { return view('collections.create'); })->name('collections.create');

    // Analytics routes
    Route::get('analytics/overview', [MainDashboardController::class, 'analyticsOverview'])->name('analytics.overview');
    Route::get('analytics/books', function() { return view('analytics.books'); })->name('analytics.books');
    Route::get('analytics/users', function() { return view('analytics.users'); })->name('analytics.users');
    Route::get('analytics/revenue', function() { return view('analytics.revenue'); })->name('analytics.revenue');
    Route::get('analytics/trends', function() { return view('analytics.trends'); })->name('analytics.trends');

    // Users management routes
    Route::get('users', [MainDashboardController::class, 'usersIndex'])->name('users.index');
    Route::get('users/active', function() { return view('users.active'); })->name('users.active');
    Route::get('users/subscriptions', function() { return view('users.subscriptions'); })->name('users.subscriptions');
    Route::get('users/permissions', function() { return view('users.permissions'); })->name('users.permissions');

    // Marketing routes
    Route::get('marketing/campaigns', [MainDashboardController::class, 'marketingCampaigns'])->name('marketing.campaigns');
    Route::get('marketing/newsletters', function() { return view('marketing.newsletters'); })->name('marketing.newsletters');
    Route::get('marketing/promotions', function() { return view('marketing.promotions'); })->name('marketing.promotions');
    Route::get('marketing/social', function() { return view('marketing.social'); })->name('marketing.social');

    // System routes
    Route::get('system/settings', [MainDashboardController::class, 'systemSettings'])->name('system.settings');
    Route::get('system/backup', function() { return view('system.backup'); })->name('system.backup');
    Route::get('system/logs', function() { return view('system.logs'); })->name('system.logs');
    Route::get('system/maintenance', function() { return view('system.maintenance'); })->name('system.maintenance');

    // Settings route
    Route::get('settings', function() { return view('settings.index'); })->name('settings');
    
    // Admin routes
    Route::middleware('is-admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/realtime-data', [App\Http\Controllers\Admin\DashboardController::class, 'getRealtimeData'])->name('dashboard.realtime-data');
        Route::get('/dashboard/hourly-activity', [App\Http\Controllers\Admin\DashboardController::class, 'getHourlyActivity'])->name('dashboard.hourly-activity');
        Route::get('/dashboard/user-growth', [App\Http\Controllers\Admin\DashboardController::class, 'getUserGrowthTrend'])->name('dashboard.user-growth');

        // Admin Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
        Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');


        // Users Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/active', [AdminController::class, 'usersActive'])->name('users.active');
        // Permissions & Roles Management
        Route::get('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions');
        Route::post('/roles', [App\Http\Controllers\Admin\PermissionController::class, 'createRole'])->name('roles.create');
        Route::get('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'getRole'])->name('roles.get');
        Route::put('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'updateRole'])->name('roles.update');
        Route::delete('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'deleteRole'])->name('roles.delete');
        Route::post('/assign-role', [App\Http\Controllers\Admin\PermissionController::class, 'assignRole'])->name('assign-role');
        Route::post('/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'createPermission'])->name('permissions.create');
        Route::post('/users/create', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');

        // Books Management
        Route::get('/books', [AdminController::class, 'books'])->name('books');
        Route::get('/books/create', function() { return view('books.create'); })->name('books.create');
        Route::get('/books/{book}', [AdminController::class, 'showBook'])->name('books.show');
        Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('books.edit');
        Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
        Route::patch('/books/{book}/approve', [AdminController::class, 'approveBook'])->name('books.approve');
        Route::patch('/books/{book}/reject', [AdminController::class, 'rejectBook'])->name('books.reject');
        Route::post('/books/{book}/suspend', [AdminController::class, 'suspendBook'])->name('books.suspend');
        Route::post('/books/{book}/review', [AdminController::class, 'putUnderReview'])->name('books.review');
        Route::delete('/books/{book}', [AdminController::class, 'deleteBook'])->name('books.delete');

        // Enhanced status management
        Route::patch('/books/{book}/status', [App\Http\Controllers\Admin\BookStatusController::class, 'changeStatus'])->name('books.change-status');
        Route::get('/books/{book}/status-history', [App\Http\Controllers\Admin\BookStatusController::class, 'showHistory'])->name('books.status-history');
        Route::get('/books/status-stats', [App\Http\Controllers\Admin\BookStatusController::class, 'statusStats'])->name('books.status-stats');
        Route::post('/books/bulk-status', [App\Http\Controllers\Admin\BookStatusController::class, 'bulkStatusChange'])->name('books.bulk-status');


        // Categories
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

        // Analytics & Reports
        Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports');
        Route::get('/reports/realtime-data', [App\Http\Controllers\Admin\ReportsController::class, 'getRealtimeData'])->name('reports.realtime-data');
        Route::post('/reports/export-csv', [App\Http\Controllers\Admin\ReportsController::class, 'exportCsv'])->name('reports.export-csv');
        Route::post('/reports/export-pdf', [App\Http\Controllers\Admin\ReportsController::class, 'exportPdf'])->name('reports.export-pdf');
        Route::post('/reports/generate-full', [App\Http\Controllers\Admin\ReportsController::class, 'generateFullReport'])->name('reports.generate-full');
        // Activity Management
        Route::get('/activity', [App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activity');
        Route::get('/activity/realtime-data', [App\Http\Controllers\Admin\ActivityController::class, 'getRealtimeData'])->name('activity.realtime-data');

        // System & Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/settings/logos', [AdminController::class, 'updateLogos'])->name('settings.logos.update');
        Route::delete('/settings/logo/{type}', [AdminController::class, 'deleteLogo'])->name('settings.logo.delete');
        // Settings routes with proper controllers
        Route::get('/settings', [App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings');
        Route::get('/settings/general', [App\Http\Controllers\Admin\AdminSettingsController::class, 'general'])->name('settings.general');
        Route::get('/settings/security', [App\Http\Controllers\Admin\AdminSettingsController::class, 'security'])->name('settings.security');
        Route::get('/settings/email', [App\Http\Controllers\Admin\AdminSettingsController::class, 'email'])->name('settings.email');
        Route::get('/settings/maintenance', [App\Http\Controllers\Admin\AdminSettingsController::class, 'maintenance'])->name('settings.maintenance');
        Route::post('/settings/update', [App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('settings.update');
        Route::get('/system-settings', function() { return view('admin.system-settings'); })->name('system-settings');
        Route::get('/themes', function() { return view('admin.themes'); })->name('themes');

        // Homepage content management
        Route::get('/homepage-content', [App\Http\Controllers\Admin\HomepageContentController::class, 'index'])->name('homepage-content.index');
        Route::put('/homepage-content', [App\Http\Controllers\Admin\HomepageContentController::class, 'update'])->name('homepage-content.update');
        // Backup Management
        Route::get('/backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup');
        Route::post('/backup/create', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/delete/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backup.delete');
        Route::post('/backup/cleanup', [App\Http\Controllers\Admin\BackupController::class, 'cleanup'])->name('backup.cleanup');
        Route::get('/logs', function() { return view('admin.logs'); })->name('logs');

        // Additional Features
        Route::get('/audit', function() { return view('admin.audit.index'); })->name('audit');
        Route::get('/emails', function() { return view('admin.emails.index'); })->name('emails');
        Route::get('/notifications', function() { return view('admin.notifications.index'); })->name('notifications');
        Route::get('/subscriptions', function() { return view('admin.subscriptions.index'); })->name('subscriptions');
    });

    // Admin-only management routes (outside admin prefix for main dashboard access)
    Route::middleware('is-admin')->group(function () {
        // Authors management routes
        Route::get('admin/authors', [MainDashboardController::class, 'authorsIndex'])->name('admin.authors.index');
        Route::get('admin/authors/featured', function() { return view('authors.featured'); })->name('admin.authors.featured');
        Route::get('admin/authors/applications', function() { return view('authors.applications'); })->name('admin.authors.applications');
    });

    // Author routes
    Route::middleware('is-author')->prefix('author')->name('author.')->group(function () {
        Route::get('/dashboard', [AuthorController::class, 'dashboard'])->name('dashboard');
        Route::get('/books', [AuthorController::class, 'books'])->name('books');

        // Book creation routes for authors (MUST be before parameterized routes)
        Route::get('/books/create', [AuthorController::class, 'createBook'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');

        Route::get('/books/{book}', [AuthorController::class, 'showBook'])->name('books.show');
        Route::get('/books/{book}/edit', [AuthorController::class, 'editBook'])->name('books.edit');
        Route::patch('/books/{book}', [AuthorController::class, 'updateBook'])->name('books.update');
        Route::delete('/books/{book}', [AuthorController::class, 'deleteBook'])->name('books.delete');
        Route::get('/analytics', [AuthorController::class, 'analytics'])->name('analytics');
        Route::get('/analytics/downloads', [AuthorController::class, 'analyticsDownloads'])->name('analytics.downloads');
        Route::get('/analytics/views', [AuthorController::class, 'analyticsViews'])->name('analytics.views');
        Route::get('/analytics/readers', [AuthorController::class, 'analyticsReaders'])->name('analytics.readers');

        // Revenue routes
        Route::get('/revenue', [AuthorController::class, 'revenue'])->name('revenue');
        Route::get('/revenue/reports', [AuthorController::class, 'revenueReports'])->name('revenue.reports');
        Route::get('/revenue/payouts', [AuthorController::class, 'payouts'])->name('revenue.payouts');

        // Promotions routes
        Route::get('/promotions', [AuthorController::class, 'promotions'])->name('promotions');
        Route::get('/promotions/create', [AuthorController::class, 'createPromotion'])->name('promotions.create');
        Route::post('/promotions', [AuthorController::class, 'storePromotion'])->name('promotions.store');
        Route::get('/promotions/history', [AuthorController::class, 'promotionsHistory'])->name('promotions.history');

        // Tools routes
        Route::get('/tools', [AuthorController::class, 'tools'])->name('tools');
        Route::get('/tools/writing', [AuthorController::class, 'writingTools'])->name('tools.writing');
        Route::get('/tools/marketing', [AuthorController::class, 'marketingTools'])->name('tools.marketing');

        // Collections routes
        Route::get('/collections', [AuthorController::class, 'collections'])->name('collections');
        Route::get('/collections/create', [AuthorController::class, 'createCollection'])->name('collections.create');
        Route::post('/collections', [AuthorController::class, 'storeCollection'])->name('collections.store');

        // Reviews routes
        Route::get('/reviews', [AuthorController::class, 'reviews'])->name('reviews');
        Route::get('/reviews/{review}', [AuthorController::class, 'showReview'])->name('reviews.show');
        Route::post('/reviews/{review}/respond', [AuthorController::class, 'respondToReview'])->name('reviews.respond');

        // Support routes
        Route::get('/support', [AuthorController::class, 'support'])->name('support');
        Route::post('/support/ticket', [AuthorController::class, 'createSupportTicket'])->name('support.ticket');
        Route::get('/support/faq', [AuthorController::class, 'faq'])->name('support.faq');

        // Profile routes for authors
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
        Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/admin.php';

// Author Authentication Routes
Route::middleware(['guest', 'author.guest'])->group(function () {
    Route::get('/author/login', [App\Http\Controllers\Auth\AuthorAuthController::class, 'create'])
        ->name('author.login');
    Route::post('/author/login', [App\Http\Controllers\Auth\AuthorAuthController::class, 'store'])
        ->name('author.login.submit');
    Route::get('/author/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
        ->name('author.register');
    Route::post('/author/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
        ->name('author.register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/author/logout', [App\Http\Controllers\Auth\AuthorAuthController::class, 'destroy'])
        ->name('author.logout');
});