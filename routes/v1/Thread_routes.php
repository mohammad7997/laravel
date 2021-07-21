<?php

use \App\Http\Controllers\Api\V1\Thread\ThreadController;
use \App\Http\Controllers\Api\V1\Answer\AnswerController;


// start Thread route
Route::prefix('Thread/')->name('Thread.')->group(function () {
    Route::get('index', [ThreadController::class, 'index'])->name('index');
    Route::get('show/{slug}', [ThreadController::class, 'show'])->name('show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('create', [ThreadController::class, 'store'])->name('store');
        Route::put('update/{thread}', [ThreadController::class, 'update'])->name('update');
        Route::put('bestAnswer/{thread}', [ThreadController::class, 'bestAnswerThread'])->name('bestAnswer');
        Route::delete('delete/{thread}', [ThreadController::class, 'destroy'])->name('delete');
    });
});
//end Thread route

//start Answer route
Route::prefix('Thread/Answer/')->name('Answer.')->group(function () {
    Route::get('all', [AnswerController::class, 'index'])->name('all');
    Route::post('create/{thread}', [AnswerController::class, 'store'])->name('store');
    Route::post('update/{answer}', [AnswerController::class, 'update'])->name('update');
    Route::delete('delete/{answer}', [AnswerController::class, 'destroy'])->name('delete');
});
//end Answer route









