<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Auth::routes(['register' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('years', App\Http\Controllers\Admin\YearController::class);
    Route::resource('levels', App\Http\Controllers\Admin\LevelController::class);
    Route::resource('regions', App\Http\Controllers\Admin\RegionController::class);
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);
    Route::resource('result-titles', App\Http\Controllers\Admin\ResultTitleController::class);
    Route::resource('results', App\Http\Controllers\Admin\ResultController::class);
    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('admins', App\Http\Controllers\Admin\AdminManagementController::class);
});
