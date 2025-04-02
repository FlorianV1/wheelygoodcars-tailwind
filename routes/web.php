<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [CarController::class, 'index'])->name('cars.index');

Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

Route::get('/api/cars/fetch-details', [CarController::class, 'fetchCarDetails']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-cars', [CarController::class, 'my'])->name('cars.my');

    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::post('/cars/{car}/buy', [CarController::class, 'buy'])->name('cars.buy')->middleware('auth');

    Route::post('/cars/{car}/update-status', [CarController::class, 'updateStatus'])->name('cars.updateStatus');
    Route::post('/cars/{car}/update-price', [CarController::class, 'updatePrice'])->name('cars.updatePrice');
    Route::post('/cars/{car}/update-tags', [CarController::class, 'updateTags'])->name('cars.updateTags');

    Route::post('/cars/{car}/favorite', [CarController::class, 'toggleFavorite'])->name('cars.favorite');
    Route::get('/cars/{car}/pdf', [CarController::class, 'generatePdf'])->name('cars.pdf');
});
