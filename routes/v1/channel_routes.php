<?php

use \App\Http\Controllers\Api\v1\Channel\ChannelController;

Route::prefix('Channel/')->group(function () {
    Route::get('getList', [ChannelController::class, 'getListChannel'])->name('Channel.getList');

    Route::middleware(['can:channel management', 'auth:sanctum'])->group(function () {
        Route::post('create', [ChannelController::class, 'createChannel'])->name('Channel.create');
        Route::put('update/{channel}', [ChannelController::class, 'updateChannel'])->name('Channel.update');
        Route::delete('delete/{channel}', [ChannelController::class, 'deleteChannel'])->name('Channel.delete');
    });
});

