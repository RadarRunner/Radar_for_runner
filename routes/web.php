<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Connexion
Route::post('/connect', [AuthController::class, 'login'])->name('connect');

Route::get('/debug-disks', function () {
    return response()->json(array_keys(config('filesystems.disks')));
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

Route::get('/debug-bucket', function () {
    return response()->json([
        'env_AWS_BUCKET' => env('AWS_BUCKET'),
        'config_bucket' => config('filesystems.disks.s3.bucket'),
        'env_AWS_ENDPOINT' => env('AWS_ENDPOINT'),
        'config_endpoint' => config('filesystems.disks.s3.endpoint'),
        'env_AWS_URL' => env('AWS_URL'),
        'config_url' => config('filesystems.disks.s3.url'),
        'env_AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID') ? 'set' : 'missing',
        'env_AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY') ? 'set' : 'missing',
        'default_disk' => config('filesystems.default'),
    ]);
});

Route::get('/clear-laravel-cache', function () {
    Artisan::call('optimize:clear');

    return response()->json([
        'message' => 'Cache cleared',
        'output' => Artisan::output(),
    ]);
});
