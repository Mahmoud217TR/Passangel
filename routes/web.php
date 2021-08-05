<?php

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

// Auth 
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/addpassword', [App\Http\Controllers\NavigationController::class, 'addpass'])->name('addpassword');
    Route::post('/generate', [App\Http\Controllers\PasswordController::class, 'generate'])->name('generate');
    Route::post('/advancedGenerate', [App\Http\Controllers\PasswordController::class, 'advancedGenerate'])->name('advanced.generate');
    Route::post('/password/create', [App\Http\Controllers\PasswordController::class, 'create'])->name('password.create');
    Route::get('/options', [App\Http\Controllers\NavigationController::class, 'options'])->name('options');
    Route::post('/changetoken', [App\Http\Controllers\PasswordController::class, 'changeToken'])->name('token.change');
});
