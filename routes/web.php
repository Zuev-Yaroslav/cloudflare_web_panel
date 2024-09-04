<?php

use App\Http\Controllers\Cloudflare\CloudFlareAccountController;
use App\Http\Controllers\Cloudflare\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CloudflareAuthMiddlware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/cloudflare-accounts', [CloudFlareAccountController::class, 'index'])->name('cloudflare-accounts.index');
    Route::get('/cloudflare-accounts/create', [CloudFlareAccountController::class, 'create'])->name('cloudflare-accounts.create');
    Route::post('/cloudflare-accounts', [CloudFlareAccountController::class, 'store'])->name('cloudflare-accounts.store');
    Route::middleware(CloudflareAuthMiddlware::class)->group(function () {
        Route::prefix('/cloudflare-accounts/{cloudflareAccount}')->group(function () {
            Route::get('/', [CloudFlareAccountController::class, 'show'])->name('cloudflare-accounts.show');
            Route::delete('/', [CloudFlareAccountController::class, 'destroy'])->name('cloudflare-accounts.destroy');
            Route::get('/domains', [DomainController::class, 'index'])->name('cloudflare.domains.index');
            Route::get('/domains/create', [DomainController::class, 'create'])->name('cloudflare.domains.create');
            Route::post('/domains', [DomainController::class, 'store'])->name('cloudflare.domains.store');
            Route::get('/domains/{domainId}/edit', [DomainController::class, 'edit'])->name('cloudflare.domains.edit');
            Route::delete('/domains/{domainId}', [DomainController::class, 'destroy'])->name('cloudflare.domains.destroy');
            Route::patch('/domains/{domainId}/settings/{settingId}', [DomainController::class, 'updateSetting'])->name('cloudflare.domains.settings.update');
            Route::get('/domains/{domainId}/page-rules', [DomainController::class, 'indexPageRule'])->name('cloudflare.domains.page-rules.index');
            Route::get('/domains/{domainId}/page-rules/create', [DomainController::class, 'createPageRule'])->name('cloudflare.domains.page-rules.create');
            Route::post('/domains/{domainId}/page-rules', [DomainController::class, 'storePageRule'])->name('cloudflare.domains.page-rules.store');
            Route::get('/domains/{domainId}/page-rules/{pageRuleId}/edit', [DomainController::class, 'editPageRule'])->name('cloudflare.domains.page-rules.edit');
            Route::put('/domains/{domainId}/page-rules/{pageRuleId}', [DomainController::class, 'updatePageRule'])->name('cloudflare.domains.page-rules.update');
            Route::delete('/domains/{domainId}/page-rules/{pageRuleId}', [DomainController::class, 'destroyPageRule'])->name('cloudflare.domains.page-rules.destroy');
        });
    });
});

require __DIR__.'/auth.php';
