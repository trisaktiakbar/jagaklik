<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UrlScanController;

Route::prefix('v1')
    ->middleware('throttle:10,1')
    ->group(function () {
        Route::post('/scan', UrlScanController::class)
            ->name('api.v1.scan');
    });
