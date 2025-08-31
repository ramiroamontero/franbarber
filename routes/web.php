<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\Voyager\VoyagerAuthController;
use App\Http\Controllers\Voyager\VoyagerController;

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

Route::group(['prefix' => 'auth'], function () {

    Route::get('google/redirect', [VoyagerAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('google/callback', [VoyagerAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Voyager::routes();

    Route::get('/login', [VoyagerAuthController::class, 'login'])->name('voyager.login')->withoutMiddleware('auth');
    Route::get('/dashboard', [VoyagerController::class, 'index'])->name('voyager.dashboard');
    Route::post('/logout', [VoyagerController::class, 'logout'])->name('voyager.logout');


    Route::group(['prefix' => 'calendar'], function () {

        Route::get('auth/google', [GoogleCalendarController::class, 'redirectToGoogle']);
        Route::get('auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback']);
        Route::get('', [GoogleCalendarController::class, 'list'])->name('calendar.index');
        Route::post('', [GoogleCalendarController::class, 'post'])->name('calendar.store');
    });
});
