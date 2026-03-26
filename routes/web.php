<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Connexion
Route::post('/connect', [AuthController::class, 'login'])->name('connect');

Route::get('/debug-bucket', function () {
    return response()->json([
        'AWS_BUCKET' => env('AWS_BUCKET'),
        'AWS_ENDPOINT' => env('AWS_ENDPOINT'),
        'AWS_URL' => env('AWS_URL'),
        'FILESYSTEM_DISK' => env('FILESYSTEM_DISK'),
    ]);
});

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API images (lecture)
    Route::get('/api/images/{date}/{type}', [ImageController::class, 'getByDateThenType']);

    // API images (upload)
    Route::post('/api/images', [ImageController::class, 'store']);

});
