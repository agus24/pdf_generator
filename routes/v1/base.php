<?php

use App\Http\Controllers\PdfRenderController;
use App\Http\Middleware\EnforceIdempotencyMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(EnforceIdempotencyMiddleware::class)->group(function () {
    Route::post('/render', [PdfRenderController::class, 'render'])->name('render');
});
