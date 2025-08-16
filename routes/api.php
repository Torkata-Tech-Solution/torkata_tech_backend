<?php

use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/home', [App\Http\Controllers\Api\HomeController::class, 'index'])->name('home.index');
    Route::get('/info', [App\Http\Controllers\Api\InformationController::class, 'index'])->name('info.index');


    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/category', [NewsController::class, 'category'])->name('category.list');
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
    });

    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\ClientController::class, 'index'])->name('index');
        Route::get('/{slug}', [App\Http\Controllers\Api\ClientController::class, 'show'])->name('show');
    });

    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\TestimonialController::class, 'index'])->name('index');
        Route::get('/{slug}', [App\Http\Controllers\Api\TestimonialController::class, 'show'])->name('show');
    });

    Route::prefix('teams')->name('teams.')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\TeamController::class, 'index'])->name('index');
        Route::get('/{slug}', [App\Http\Controllers\Api\TeamController::class, 'show'])->name('show');
    });
});
