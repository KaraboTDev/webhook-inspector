<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [WebhookController::class, 'index'])->name('dashboard');

// Create endpoint
Route::post('/endpoints', [WebhookController::class, 'createEndpoint'])->name('endpoints.create');

// Capture incoming webhook — accepts ALL HTTP methods
Route::any('/webhook/{token}', [WebhookController::class, 'capture'])->name('webhook.capture');

// Replay a log
Route::get('/logs/{log}/replay', [WebhookController::class, 'replay'])->name('logs.replay');

// Delete a log
Route::delete('/logs/{log}', [WebhookController::class, 'deleteLog'])->name('logs.delete');

// Delete an endpoint
Route::delete('/endpoints/{endpoint}', [WebhookController::class, 'deleteEndpoint'])->name('endpoints.delete');