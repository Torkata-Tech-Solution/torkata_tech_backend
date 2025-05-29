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

    Route::apiResource('news', NewsController::class)
        ->only(['index', 'show'])
        ->names([
            'index' => 'news.index',
            'show' => 'news.show',
        ]);
});
