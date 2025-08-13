<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PermissionController;
// use App\Http\Controllers\Admin\AdminBookController; // Controller does not exist
// use App\Http\Controllers\Admin\AdminUserController; // Controller does not exist
// use App\Http\Controllers\Admin\AdminCategoryController; // Controller does not exist
// use App\Http\Controllers\Admin\AdminStatsController; // Controller does not exist
// use App\Http\Controllers\Admin\AdminSettingsController; // Controller does not exist
use App\Http\Controllers\Admin\ReportsController as AdminReportController;
// use App\Http\Controllers\Admin\AdminAuthorController; // Controller does not exist
use App\Http\Controllers\Admin\BackupController as AdminBackupController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
// use App\Http\Controllers\Admin\AdminNotificationController; // Controller does not exist
use App\Http\Controllers\Admin\HomepageContentController;
use App\Http\Controllers\Admin\BookStatusController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes pour l'espace administrateur
|
*/

Route::middleware(['auth', 'is-admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/widgets', [AdminDashboardController::class, 'widgets'])->name('dashboard.widgets');
    
    // Books Management
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [AdminController::class, 'books'])->name('index');
        Route::get('/pending', [AdminController::class, 'pendingBooks'])->name('pending');
        Route::get('/approved', [AdminController::class, 'approvedBooks'])->name('approved');
        Route::get('/rejected', [AdminController::class, 'rejectedBooks'])->name('rejected');
        Route::get('/create', [AdminController::class, 'createBook'])->name('create');
        Route::post('/', [AdminController::class, 'storeBook'])->name('store');
        Route::get('/{book}', [AdminController::class, 'bookDetails'])->name('show');
        Route::get('/{book}/edit', [AdminController::class, 'editBook'])->name('edit');
        Route::put('/{book}', [AdminController::class, 'updateBook'])->name('update');
        Route::delete('/{book}', [AdminController::class, 'deleteBook'])->name('destroy');
        Route::post('/{book}/approve', [AdminController::class, 'approveBook'])->name('approve');
        Route::post('/{book}/reject', [AdminController::class, 'rejectBook'])->name('reject');
        Route::post('/{book}/feature', [AdminController::class, 'featureBook'])->name('feature');
        Route::post('/{book}/unfeature', [AdminController::class, 'unfeatureBook'])->name('unfeature');
        Route::get('/{book}/status-history', [BookStatusController::class, 'history'])->name('status-history');
        Route::post('/bulk-action', [AdminController::class, 'bulkBookAction'])->name('bulk-action');
        Route::get('/export', [AdminController::class, 'exportBooks'])->name('export');
        Route::post('/import', [AdminController::class, 'importBooks'])->name('import');
    });
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
        Route::get('/active', [AdminController::class, 'activeUsers'])->name('active');
        Route::get('/suspended', [AdminController::class, 'suspended'])->name('suspended');
        Route::get('/banned', [AdminController::class, 'banned'])->name('banned');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminController::class, 'userDetails'])->name('show');
        Route::get('/{user}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/suspend', [AdminController::class, 'suspend'])->name('suspend');
        Route::post('/{user}/unsuspend', [AdminController::class, 'unsuspend'])->name('unsuspend');
        Route::post('/{user}/ban', [AdminController::class, 'ban'])->name('ban');
        Route::post('/{user}/unban', [AdminController::class, 'unban'])->name('unban');
        Route::post('/{user}/verify-email', [AdminController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('reset-password');
        Route::get('/{user}/activity', [AdminController::class, 'activity'])->name('activity');
        Route::get('/{user}/permissions', [AdminController::class, 'permissions'])->name('permissions');
        Route::post('/{user}/permissions', [AdminController::class, 'updatePermissions'])->name('permissions.update');
        Route::post('/bulk-action', [AdminController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::post('/import', [AdminController::class, 'import'])->name('import');
    });
    
    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [AdminController::class, 'categories'])->name('index');
        Route::get('/create', [AdminController::class, 'createCategory'])->name('create');
        Route::post('/', [AdminController::class, 'storeCategory'])->name('store');
        Route::get('/{category}/edit', [AdminController::class, 'editCategory'])->name('edit');
        Route::put('/{category}', [AdminController::class, 'updateCategory'])->name('update');
        Route::delete('/{category}', [AdminController::class, 'deleteCategory'])->name('destroy');
        Route::post('/{category}/feature', [AdminController::class, 'feature'])->name('feature');
        Route::post('/{category}/unfeature', [AdminController::class, 'unfeature'])->name('unfeature');
        Route::post('/reorder', [AdminController::class, 'reorder'])->name('reorder');
    });
    
    // Statistics & Analytics
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', [AdminController::class, 'overview'])->name('overview');
        Route::get('/downloads', [AdminController::class, 'downloads'])->name('downloads');
        Route::get('/users', [AdminController::class, 'users'])->name('active-users');
        Route::get('/books', [AdminController::class, 'books'])->name('books');
        Route::get('/revenue', [AdminController::class, 'revenue'])->name('revenue');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/real-time', [AdminController::class, 'realTime'])->name('real-time');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::post('/generate-report', [AdminController::class, 'generateReport'])->name('generate-report');
    });
    
    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminController::class, 'settings'])->name('index');
        Route::get('/general', [AdminController::class, 'general'])->name('general');
        Route::get('/security', [AdminController::class, 'security'])->name('security');
        Route::get('/email', [AdminController::class, 'email'])->name('emails');
        Route::get('/maintenance', [AdminController::class, 'maintenance'])->name('maintenance');
        Route::get('/payment', [AdminController::class, 'payment'])->name('payment');
        Route::get('/api', [AdminController::class, 'api'])->name('api');
        Route::get('/social', [AdminController::class, 'social'])->name('social');
        Route::get('/seo', [AdminController::class, 'seo'])->name('seo');
        Route::post('/update', [AdminController::class, 'updateSettings'])->name('update');
        Route::post('/logos', [AdminController::class, 'updateLogos'])->name('logos.update');
        Route::delete('/logo/{type}', [AdminController::class, 'deleteLogo'])->name('logo.delete');
        Route::post('/cache-clear', [AdminController::class, 'clearCache'])->name('cache.clear');
        Route::post('/maintenance-mode', [AdminController::class, 'toggleMaintenance'])->name('maintenance.toggle');
    });
    
    // Authors Management
    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/pending', [AdminController::class, 'pending'])->name('pending');
        Route::get('/verified', [AdminController::class, 'verified'])->name('verified');
        Route::get('/featured', [AdminController::class, 'featured'])->name('featured');
        Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
        Route::get('/{author}', [AdminController::class, 'show'])->name('show');
        Route::get('/{author}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{author}', [AdminController::class, 'update'])->name('update');
        Route::post('/{author}/verify', [AdminController::class, 'verify'])->name('verify');
        Route::post('/{author}/reject', [AdminController::class, 'reject'])->name('reject');
        Route::post('/{author}/feature', [AdminController::class, 'feature'])->name('feature');
        Route::post('/{author}/unfeature', [AdminController::class, 'unfeature'])->name('unfeature');
        Route::post('/{author}/commission', [AdminController::class, 'updateCommission'])->name('commission');
        Route::get('/{author}/earnings', [AdminController::class, 'earnings'])->name('earnings');
        Route::get('/{author}/books', [AdminController::class, 'books'])->name('books');
    });
    
    // Activity & Logs
    Route::prefix('activity')->name('activity.')->group(function () {
        Route::get('/', [AdminActivityController::class, 'index'])->name('index');
        Route::get('/logs', [AdminActivityController::class, 'logs'])->name('logs');
        Route::get('/audit', [AdminActivityController::class, 'audit'])->name('audit');
        Route::get('/login-history', [AdminActivityController::class, 'loginHistory'])->name('login-history');
        Route::get('/export', [AdminActivityController::class, 'export'])->name('export');
        Route::delete('/clear', [AdminActivityController::class, 'clear'])->name('clear');
    });
    
    // Reports Management
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/financial', [AdminReportController::class, 'financial'])->name('financial');
        Route::get('/usage', [AdminReportController::class, 'usage'])->name('usage');
        Route::get('/content', [AdminReportController::class, 'content'])->name('content');
        Route::get('/user-behavior', [AdminReportController::class, 'userBehavior'])->name('user-behavior');
        Route::post('/generate', [AdminReportController::class, 'generate'])->name('generate');
        Route::get('/scheduled', [AdminReportController::class, 'scheduled'])->name('scheduled');
        Route::post('/schedule', [AdminReportController::class, 'schedule'])->name('schedule');
        Route::get('/download/{report}', [AdminReportController::class, 'download'])->name('download');
    });
    
    // Backup Management
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [AdminBackupController::class, 'index'])->name('index');
        Route::post('/create', [AdminBackupController::class, 'create'])->name('create');
        Route::post('/restore/{backup}', [AdminBackupController::class, 'restore'])->name('restore');
        Route::delete('/{backup}', [AdminBackupController::class, 'destroy'])->name('destroy');
        Route::get('/download/{backup}', [AdminBackupController::class, 'download'])->name('download');
        Route::post('/schedule', [AdminBackupController::class, 'schedule'])->name('schedule');
    });
    
    // Notifications Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::post('/broadcast', [AdminController::class, 'broadcast'])->name('broadcast');
        Route::get('/templates', [AdminController::class, 'templates'])->name('templates');
        Route::post('/templates', [AdminController::class, 'saveTemplate'])->name('templates.save');
        Route::delete('/templates/{template}', [AdminController::class, 'deleteTemplate'])->name('templates.delete');
    });
    
    // Homepage Content Management
    Route::prefix('homepage')->name('homepage-content.')->group(function () {
        Route::get('/', [HomepageContentController::class, 'index'])->name('index');
        Route::put('/', [HomepageContentController::class, 'update'])->name('update');
        Route::post('/sections/reorder', [HomepageContentController::class, 'reorderSections'])->name('sections.reorder');
        Route::post('/banner', [HomepageContentController::class, 'updateBanner'])->name('banner.update');
        Route::post('/featured', [HomepageContentController::class, 'updateFeatured'])->name('featured.update');
    });
    
    // Email Management
    Route::prefix('emails')->name('emails.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/templates', [AdminController::class, 'templates'])->name('templates');
        Route::get('/templates/{template}/edit', [AdminController::class, 'editTemplate'])->name('templates.edit');
        Route::put('/templates/{template}', [AdminController::class, 'updateTemplate'])->name('templates.update');
        Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        Route::post('/test', [AdminController::class, 'sendTest'])->name('test');
    });
    
    // Subscriptions Management
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/plans', [AdminController::class, 'plans'])->name('plans');
        Route::get('/plans/create', [AdminController::class, 'createPlan'])->name('plans.create');
        Route::post('/plans', [AdminController::class, 'storePlan'])->name('plans.store');
        Route::get('/plans/{plan}/edit', [AdminController::class, 'editPlan'])->name('plans.edit');
        Route::put('/plans/{plan}', [AdminController::class, 'updatePlan'])->name('plans.update');
        Route::delete('/plans/{plan}', [AdminController::class, 'destroyPlan'])->name('plans.destroy');
        Route::get('/active', [AdminController::class, 'active'])->name('active');
        Route::get('/expired', [AdminController::class, 'expired'])->name('expired');
        Route::get('/revenue', [AdminController::class, 'revenue'])->name('revenue');
    });
    
    // System Tools
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/info', [AdminController::class, 'info'])->name('info');
        Route::get('/health', [AdminController::class, 'health'])->name('health');
        Route::get('/performance', [AdminController::class, 'performance'])->name('performance');
        Route::post('/optimize', [AdminController::class, 'optimize'])->name('optimize');
        Route::get('/queue', [AdminController::class, 'queue'])->name('queue');
        Route::post('/queue/retry', [AdminController::class, 'retryQueue'])->name('queue.retry');
        Route::post('/queue/clear', [AdminController::class, 'clearQueue'])->name('queue.clear');
    });
    
    // Themes Management
    Route::get('/themes', [AdminController::class, 'index'])->name('themes');
    Route::post('/themes/activate', [AdminController::class, 'activate'])->name('themes.activate');
    Route::post('/themes/customize', [AdminController::class, 'customize'])->name('themes.customize');
    
    // Permissions Management  
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/permissions', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('/roles', [PermissionController::class, 'roles'])->name('roles');
    Route::post('/roles', [PermissionController::class, 'createRole'])->name('roles.create');
    Route::put('/roles/{role}', [PermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [PermissionController::class, 'deleteRole'])->name('roles.delete');
});