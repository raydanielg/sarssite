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
Route::get('/sitemap', [App\Http\Controllers\LandingController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap.xml', [App\Http\Controllers\LandingController::class, 'sitemapXml'])->name('sitemap.xml');
Route::get('/api/exams-by-year', [App\Http\Controllers\Landing\ResultsController::class, 'getExamsByYear'])->name('api.exams-by-year');
Route::get('/results', [App\Http\Controllers\Landing\ResultsController::class, 'index'])->name('results.index');
Route::get('/results/tour', [App\Http\Controllers\Landing\ResultsController::class, 'tour'])->name('results.tour');
Route::get('/results/{year}', [App\Http\Controllers\Landing\ResultsController::class, 'showYear'])->name('results.year');
Route::get('/results/{year}/{level_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showLevelResults'])->name('results.level');
Route::get('/results/{year}/{level_slug}/{title_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showFinalResults'])->name('results.final');
Route::get('/view-results', [App\Http\Controllers\Landing\ResultsController::class, 'viewPdf'])->name('results.view_pdf');
Route::get('/download-results', [App\Http\Controllers\Landing\ResultsController::class, 'downloadPdf'])->name('results.download_pdf');

Auth::routes(['register' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('years', App\Http\Controllers\Admin\YearController::class);
    Route::resource('result-types', App\Http\Controllers\ResultTypeController::class);
    Route::resource('levels', App\Http\Controllers\Admin\LevelController::class);
    Route::resource('regions', App\Http\Controllers\Admin\RegionController::class);
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);
    Route::resource('result-summaries', App\Http\Controllers\Admin\ResultSummaryController::class);
    Route::post('result-titles/bulk-delete', [App\Http\Controllers\Admin\ResultTitleController::class, 'bulkDelete'])->name('result-titles.bulk-delete');
    Route::get('bulk-summaries', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkUploadForm'])->name('result-summaries.bulk-upload-form');
    Route::post('bulk-summaries', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkUpload'])->name('result-summaries.bulk-upload');
    Route::resource('result-titles', App\Http\Controllers\Admin\ResultTitleController::class);
    Route::resource('results', App\Http\Controllers\Admin\ResultController::class);
    Route::get('results-bulk-upload', [App\Http\Controllers\Admin\ResultController::class, 'bulkUploadForm'])->name('results.bulk-upload-form');
    Route::post('results/bulk-upload', [App\Http\Controllers\Admin\ResultController::class, 'bulkUpload'])->name('results.bulk-upload');
    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('admins', App\Http\Controllers\Admin\AdminManagementController::class);
});
