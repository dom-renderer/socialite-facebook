<?php

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('instagram/deauth', [FacebookController::class, 'deauth']);
Route::get('instagram/deletion', [FacebookController::class, 'deletion']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacyPolicy'])->name('privacy-policy');

Route::middleware(['auth'])->group(function() {
    
    Route::get('facebook/auth', [FacebookController::class, 'auth'])->name('facebook.auth');
    Route::get('facebook/auth/callback', [FacebookController::class, 'callback'])->name('facebook.auth.callback');

    Route::get('instagram/auth', [InstagramController::class, 'auth'])->name('instagram.auth');
    Route::get('instagram/auth/callback', [InstagramController::class, 'callback'])->name('instagram.auth.callback');

});