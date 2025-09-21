<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientsController;

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

Route::group(['prefix' => 'auth'], function () {

    Route::get('google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
});


Route::group(['prefix' => 'appointments',  'middleware' => ['auth', 'cors']], function () {
    Route::get('', [AppointmentsController::class, 'index'])->name('appointments.index');
    Route::get('appointments', [AppointmentsController::class, 'appointments'])->name('appointments.appointments');
    Route::post('', [AppointmentsController::class, 'store'])->name('appointments.store');
});

Route::group(['prefix' => 'clients', 'middleware' => ['auth', 'cors']], function () {
    Route::get('', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('datatable', [ClientsController::class, 'datatable'])->name('clients.datatable');
    Route::post('', [ClientsController::class, 'store'])->name('clients.store');
});

Route::group(['middleware' => ['cors']], function () {
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
