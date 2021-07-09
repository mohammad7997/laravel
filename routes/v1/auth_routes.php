<?php

use \App\Http\Controllers\Api\V1\Auth\AuthController;

Route::prefix('Auth/')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('showInfo', [AuthController::class, 'showInfoUser'])->name('auth.showInfo');
});
