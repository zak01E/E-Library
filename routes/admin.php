<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminBackupController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminNotificationController;
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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/widgets', [AdminDashboardController::class, 'widgets'])->name('dashboard.widgets');
    
    // Books Management
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [AdminController::class, 'books'])->name('index');
        Route::get('/pending', [AdminController::class, 'pendingBooks'])->name('pending');
        Route::get('/approved', [AdminController::class, 'approvedBooks'])->name('approved');
        Route::get('/rejected', [AdminController::class, 'rejectedBooks'])->name('rejected');
        Route::get('/create', [AdminBookController::class, 'create'])->name('create');
        Route::post('/', [AdminBookController::class, 'store'])->name('store');
        Route::get('/{book}', [AdminController::class, 'bookDetails'])->name('show');
        Route::get('/{book}/edit', [AdminController::class, 'editBook'])->name('edit');
        Route::put('/{book}', [AdminController::class, 'updateBook'])->name('update');
        Route::delete('/{book}', [AdminBookController::class, 'destroy'])->name('destroy');
        Route::post('/{book}/approve', [AdminController::class, 'approveBook'])->name('approve');
        Route::post('/{book}/reject', [AdminController::class, 'rejectBook'])->name('reject');
        Route::post('/{book}/feature', [AdminBookController::class, 'feature'])->name('feature');
        Route::post('/{book}/unfeature', [AdminBookController::class, 'unfeature'])->name('unfeature');
        Route::get('/{book}/status-history', [BookStatusController::class, 'history'])->name('status-history');
        Route::post('/bulk-action', [AdminBookController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [AdminBookController::class, 'export'])->name('export');
        Route::post('/import', [AdminBookController::class, 'import'])->name('import');
    });
    
    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
        Route::get('/active', [AdminController::class, 'activeUsers'])->name('active');
        Route::get('/suspended', [AdminUserController::class, 'suspended'])->name('suspended');
        Route::get('/banned', [AdminUserController::class, 'banned'])->name('banned');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminController::class, 'userDetails'])->name('show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/suspend', [AdminUserController::class, 'suspend'])->name('suspend');
        Route::post('/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('unsuspend');
        Route::post('/{user}/ban', [AdminUserController::class, 'ban'])->name('ban');
        Route::post('/{user}/unban', [AdminUserController::class, 'unban'])->name('unban');
        Route::post('/{user}/verify-email', [AdminUserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('reset-password');
        Route::get('/{user}/activity', [AdminUserController::class, 'activity'])->name('activity');
        Route::get('/{user}/permissions', [AdminUserController::class, 'permissions'])->name('permissions');
        Route::post('/{user}/permissions', [AdminUserController::class, 'updatePermissions'])->name('permissions.update');
        Route::post('/bulk-action', [AdminUserController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export', [AdminUserController::class, 'export'])->name('export');
        Route::post('/import', [AdminUserController::class, 'import'])->name('import');
    });
    
    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}/feature', [AdminCategoryController::class, 'feature'])->name('feature');
        Route::post('/{category}/unfeature', [AdminCategoryController::class, 'unfeature'])->name('unfeature');
        Route::post('/reorder', [AdminCategoryController::class, 'reorder'])->name('reorder');
    });
    
    // Statistics & Analytics
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', [AdminStatsController::class, 'overview'])->name('overview');
        Route::get('/downloads', [AdminStatsController::class, 'downloads'])->name('downloads');
        Route::get('/users', [AdminStatsController::class, 'users'])->name('active-users');
        Route::get('/books', [AdminStatsController::class, 'books'])->name('books');
        Route::get('/revenue', [AdminStatsController::class, 'revenue'])->name('revenue');
        Route::get('/reports', [AdminStatsController::class, 'reports'])->name('reports');
        Route::get('/real-time', [AdminStatsController::class, 'realTime'])->name('real-time');
        Route::get('/export', [AdminStatsController::class, 'export'])->name('export');
        Route::post('/generate-report', [AdminStatsController::class, 'generateReport'])->name('generate-report');
    });
    
    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminController::class, 'settings'])->name('index');
        Route::get('/general', [AdminSettingsController::class, 'general'])->name('general');
        Route::get('/security', [AdminSettingsController::class, 'security'])->name('security');
        Route::get('/email', [AdminSettingsController::class, 'email'])->name('emails');
        Route::get('/maintenance', [AdminSettingsController::class, 'maintenance'])->name('maintenance');
        Route::get('/payment', [AdminSettingsController::class, 'payment'])->name('payment');
        Route::get('/api', [AdminSettingsController::class, 'api'])->name('api');
        Route::get('/social', [AdminSettingsController::class, 'social'])->name('social');
        Route::get('/seo', [AdminSettingsController::class, 'seo'])->name('seo');
        Route::post('/update', [AdminController::class, 'updateSettings'])->name('update');
        Route::post('/logos', [AdminController::class, 'updateLogos'])->name('logos.update');
        Route::delete('/logo/{type}', [AdminController::class, 'deleteLogo'])->name('logo.delete');
        Route::post('/cache-clear', [AdminSettingsController::class, 'clearCache'])->name('cache.clear');
        Route::post('/maintenance-mode', [AdminSettingsController::class, 'toggleMaintenance'])->name('maintenance.toggle');
    });
    
    // Authors Management
    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('/', [AdminAuthorController::class, 'index'])->name('index');
        Route::get('/pending', [AdminAuthorController::class, 'pending'])->name('pending');
        Route::get('/verified', [AdminAuthorController::class, 'verified'])->name('verified');
        Route::get('/featured', [AdminAuthorController::class, 'featured'])->name('featured');
        Route::get('/applications', [AdminAuthorController::class, 'applications'])->name('applications');
        Route::get('/{author}', [AdminAuthorController::class, 'show'])->name('show');
        Route::get('/{author}/edit', [AdminAuthorController::class, 'edit'])->name('edit');
        Route::put('/{author}', [AdminAuthorController::class, 'update'])->name('update');
        Route::post('/{author}/verify', [AdminAuthorController::class, 'verify'])->name('verify');
        Route::post('/{author}/reject', [AdminAuthorController::class, 'reject'])->name('reject');
        Route::post('/{author}/feature', [AdminAuthorController::class, 'feature'])->name('feature');
        Route::post('/{author}/unfeature', [AdminAuthorController::class, 'unfeature'])->name('unfeature');
        Route::post('/{author}/commission', [AdminAuthorController::class, 'updateCommission'])->name('commission');
        Route::get('/{author}/earnings', [AdminAuthorController::class, 'earnings'])->name('earnings');
        Route::get('/{author}/books', [AdminAuthorController::class, 'books'])->name('books');
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
        Route::get('/', [AdminNotificationController::class, 'index'])->name('index');
        Route::get('/create', [AdminNotificationController::class, 'create'])->name('create');
        Route::post('/', [AdminNotificationController::class, 'store'])->name('store');
        Route::post('/broadcast', [AdminNotificationController::class, 'broadcast'])->name('broadcast');
        Route::get('/templates', [AdminNotificationController::class, 'templates'])->name('templates');
        Route::post('/templates', [AdminNotificationController::class, 'saveTemplate'])->name('templates.save');
        Route::delete('/templates/{template}', [AdminNotificationController::class, 'deleteTemplate'])->name('templates.delete');
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
        Route::get('/', [AdminEmailController::class, 'index'])->name('index');
        Route::get('/templates', [AdminEmailController::class, 'templates'])->name('templates');
        Route::get('/templates/{template}/edit', [AdminEmailController::class, 'editTemplate'])->name('templates.edit');
        Route::put('/templates/{template}', [AdminEmailController::class, 'updateTemplate'])->name('templates.update');
        Route::get('/logs', [AdminEmailController::class, 'logs'])->name('logs');
        Route::post('/test', [AdminEmailController::class, 'sendTest'])->name('test');
    });
    
    // Subscriptions Management
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [AdminSubscriptionController::class, 'index'])->name('index');
        Route::get('/plans', [AdminSubscriptionController::class, 'plans'])->name('plans');
        Route::get('/plans/create', [AdminSubscriptionController::class, 'createPlan'])->name('plans.create');
        Route::post('/plans', [AdminSubscriptionController::class, 'storePlan'])->name('plans.store');
        Route::get('/plans/{plan}/edit', [AdminSubscriptionController::class, 'editPlan'])->name('plans.edit');
        Route::put('/plans/{plan}', [AdminSubscriptionController::class, 'updatePlan'])->name('plans.update');
        Route::delete('/plans/{plan}', [AdminSubscriptionController::class, 'destroyPlan'])->name('plans.destroy');
        Route::get('/active', [AdminSubscriptionController::class, 'active'])->name('active');
        Route::get('/expired', [AdminSubscriptionController::class, 'expired'])->name('expired');
        Route::get('/revenue', [AdminSubscriptionController::class, 'revenue'])->name('revenue');
    });
    
    // System Tools
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/info', [AdminSystemController::class, 'info'])->name('info');
        Route::get('/health', [AdminSystemController::class, 'health'])->name('health');
        Route::get('/performance', [AdminSystemController::class, 'performance'])->name('performance');
        Route::post('/optimize', [AdminSystemController::class, 'optimize'])->name('optimize');
        Route::get('/queue', [AdminSystemController::class, 'queue'])->name('queue');
        Route::post('/queue/retry', [AdminSystemController::class, 'retryQueue'])->name('queue.retry');
        Route::post('/queue/clear', [AdminSystemController::class, 'clearQueue'])->name('queue.clear');
    });
    
    // Themes Management
    Route::get('/themes', [AdminThemeController::class, 'index'])->name('themes');
    Route::post('/themes/activate', [AdminThemeController::class, 'activate'])->name('themes.activate');
    Route::post('/themes/customize', [AdminThemeController::class, 'customize'])->name('themes.customize');
    
    // Permissions Management  
    Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('permissions');
    Route::post('/permissions', [AdminPermissionController::class, 'update'])->name('permissions.update');
    Route::get('/roles', [AdminPermissionController::class, 'roles'])->name('roles');
    Route::post('/roles', [AdminPermissionController::class, 'createRole'])->name('roles.create');
    Route::put('/roles/{role}', [AdminPermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [AdminPermissionController::class, 'deleteRole'])->name('roles.delete');
});