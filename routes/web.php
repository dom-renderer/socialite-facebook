<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacyPolicy'])->name('privacy-policy');

Route::middleware(['auth'])->group(function() {
    
    Route::get('facebook/auth', [FacebookController::class, 'auth'])->name('facebook.auth');
    Route::get('facebook/auth/callback', [FacebookController::class, 'callback'])->name('facebook.auth.callback');

});