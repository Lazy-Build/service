<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\PrettyDisplayAllFilesController::class);

Route::post('.github/webhook', App\Http\Controllers\GithubWebhooksController::class);

Route::get('{package}@{distro}:{version?}', App\Http\Controllers\ScriptController::class);

Route::get('{package}/logo.svg', App\Http\Controllers\LogoController::class);
