<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SsoController;
use App\Http\Middleware\VerifySsoToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Token Exchange Endpoint dengan Rate Limiting dan Middleware VerifySsoToken
Route::post('/sso/token', [SsoController::class, 'tokenExchange'])
    ->middleware(['throttle:60,1'])
    ->middleware(VerifySsoToken::class)
    ->name('api.sso.token');