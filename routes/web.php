<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

Route::middleware(['auth'])->group(function () {

    Route::get('/my-cars', [CarController::class, 'my'])->name('cars.my');

    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

    Route::post('/cars/{car}/update-status', [CarController::class, 'updateStatus'])->name('cars.updateStatus');
    Route::post('/cars/{car}/update-price', [CarController::class, 'updatePrice'])->name('cars.updatePrice');
    Route::post('/cars/{car}/update-tags', [CarController::class, 'updateTags'])->name('cars.updateTags');

    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');


    Route::get('/cars/{car}/pdf', [CarController::class, 'generatePdf'])->name('cars.pdf');
});

Route::get('/api/cars/fetch-details', [CarController::class, 'fetchCarDetails']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
