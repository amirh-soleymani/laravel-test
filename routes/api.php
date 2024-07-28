<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookController;

use Illuminate\Support\Facades\Route;

Route::prefix('/activity')->group( function() {

    Route::get('/index', [ActivityController::class, 'index']);
    Route::post('/create', [ActivityController::class, 'store']);
    Route::get('/show/{id}', [ActivityController::class, 'show']);
    Route::put('/update/{id}', [ActivityController::class, 'update']);
    Route::delete('/delete/{id}', [ActivityController::class, 'destroy']);
    Route::post('/imageUpload', [ActivityController::class, 'upload']);
    Route::get('/search', [ActivityController::class, 'search']);
});

Route::prefix('/book')->group( function() {

    Route::post('/bookActivity', [BookController::class, 'bookActivity']);
    Route::get('/cancelActivity', [BookController::class, 'cancelActivity']);

});
