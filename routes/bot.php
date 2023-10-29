<?php

use Illuminate\Support\Facades\Route;
use LbilTech\LaravelTelegramGitNotifier\Http\Actions\WebhookAction;
use LbilTech\LaravelTelegramGitNotifier\Http\Actions\IndexAction;

/*
|--------------------------------------------------------------------------
| Bot Routes
|--------------------------------------------------------------------------
|
| Here is where you can register bot routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "bot" middleware group. Make something great!
|
*/

Route::prefix('telegram-git-notifier')->group(function () {
    Route::prefix('webhook')->group(function () {
        Route::get('/set', [WebhookAction::class, 'set'])->name('webhook.set');
        Route::get('/delete', [WebhookAction::class, 'delete'])->name('webhook.delete');
        Route::get('/get-updates', [WebhookAction::class, 'getUpdates'])->name('webhook.get-updates');
    });
    Route::match(['get', 'post'], '/', IndexAction::class)->name('notify-send');
});
