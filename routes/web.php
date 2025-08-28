<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\Voyager\VoyagerAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('login/google', [VoyagerAuthController::class, 'googleLogin'])->name('voyager.google.login');
});

Route::get('auth/google', [GoogleCalendarController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);
Route::post('events', [GoogleCalendarController::class, 'storeEvent'])->name('events.store');
Route::get('events', [GoogleCalendarController::class, 'showEvents'])->name('events.index');
