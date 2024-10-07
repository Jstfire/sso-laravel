<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SsoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Landing Page SSO Login
Route::get('/sso/login', [SsoController::class, 'showLoginForm'])->name('sso.login');
Route::post('/sso/login', [SsoController::class, 'login'])->name('sso.authenticate');

// Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengguna
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/users/{id}/edit', [DashboardController::class, 'editUser'])->name('dashboard.users.edit');
    Route::post('/dashboard/users/{id}/update', [DashboardController::class, 'updateUser'])->name('dashboard.users.update');

    // Manajemen OAuth Clients
    Route::get('/dashboard/clients', [DashboardController::class, 'clients'])->name('dashboard.clients');
    Route::get('/dashboard/clients/create', [DashboardController::class, 'createClient'])->name('dashboard.clients.create');
    Route::post('/dashboard/clients/store', [DashboardController::class, 'storeClient'])->name('dashboard.clients.store');
    Route::delete('/dashboard/clients/{id}/delete', [DashboardController::class, 'deleteClient'])->name('dashboard.clients.delete');
});