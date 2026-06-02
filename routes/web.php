<?php

declare(strict_types=1);

use App\Http\Controllers\UnsubscribeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('signed')->group(function (): void {
    Route::get('/unsubscribe/{recipient}', [UnsubscribeController::class, 'show'])
        ->name('unsubscribe.show');
    Route::post('/unsubscribe/{recipient}', [UnsubscribeController::class, 'store'])
        ->name('unsubscribe.store');
});
