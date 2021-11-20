<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Http\Controllers\PrettyDisplayAllFilesController::class);

Route::post('.github/webhook', App\Http\Controllers\GithubWebhooksController::class);

Route::get('{package}@{distro}:{version?}', App\Http\Controllers\ScriptController::class);

Route::get('{package}/logo.svg', App\Http\Controllers\LogoController::class);
