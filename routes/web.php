<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CoverageController as AdminCoverageController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoverageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Portal\AuthController as PortalAuthController;
use App\Http\Controllers\Portal\DashboardController as PortalDashboardController;
use App\Http\Controllers\Portal\ProfileController as PortalProfileController;
use App\Http\Controllers\Portal\TicketController as PortalTicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/coverage/check', [CoverageController::class, 'check'])->name('coverage.check');

/*
|--------------------------------------------------------------------------
| Portal Pelanggan (Customer Portal) Routes
|--------------------------------------------------------------------------
*/
Route::prefix('portal')->name('portal.')->group(function () {
    // Guest customer routes
    Route::get('/login', [PortalAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PortalAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [PortalAuthController::class, 'logout'])->name('logout');

    // Protected customer routes (auto-logout dalam 1 jam tidak ada aktivitas)
    Route::middleware(['auth:customer', 'portal.timeout'])->group(function () {
        Route::get('/', [PortalDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [PortalDashboardController::class, 'index']);

        // Trouble Tickets (Laporan Gangguan)
        Route::get('/tickets', [PortalTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [PortalTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [PortalTicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [PortalTicketController::class, 'show'])->name('tickets.show');

        // Profile & Service Settings
        Route::get('/profile', [PortalProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [PortalProfileController::class, 'update'])->name('profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Site Content & Copywriting Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Packages CRUD
        Route::resource('packages', PackageController::class)->except(['show']);

        // Services CRUD
        Route::resource('services', ServiceController::class)->except(['show']);

        // Portfolios CRUD
        Route::resource('portfolios', PortfolioController::class)->except(['show']);

        // Clients CRUD
        Route::resource('clients', ClientController::class)->except(['show']);

        // Coverage Areas CRUD
        Route::resource('coverage', AdminCoverageController::class)->except(['show']);

        // Trouble Tickets Management
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
        Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');

        // Customers Management
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [AdminCustomerController::class, 'store'])->name('customers.store');
        Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

        // Contact Messages Inbox
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::patch('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
        Route::patch('/messages/{message}/replied', [MessageController::class, 'markAsReplied'])->name('messages.markAsReplied');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });
});
