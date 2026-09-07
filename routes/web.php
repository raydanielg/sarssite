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
Route::get('/results/exam/{exam_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showExamYears'])->name('results.exam_years');
Route::get('/results/exam/{exam_slug}/{year}', [App\Http\Controllers\Landing\ResultsController::class, 'showExamRegions'])->name('results.exam_regions');
Route::get('/results/exam/{exam_slug}/{year}/{region_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showExamDistricts'])->name('results.exam_districts');
Route::get('/results/exam/{exam_slug}/{year}/{region_slug}/{district_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showExamFinal'])->name('results.exam_final');
Route::get('/results/year/{year}', [App\Http\Controllers\Landing\ResultsController::class, 'showYear'])->name('results.year');
Route::get('/results/year/{year}/{region_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showDistricts'])->name('results.districts');
Route::get('/results/year/{year}/{region_slug}/{district_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showTitles'])->name('results.titles');
Route::get('/results/year/{year}/{region_slug}/{district_slug}/{title_slug}', [App\Http\Controllers\Landing\ResultsController::class, 'showFinalResults'])->name('results.final');
Route::get('/view-results', [App\Http\Controllers\Landing\ResultsController::class, 'viewPdf'])->name('results.view_pdf');
Route::get('/download-results', [App\Http\Controllers\Landing\ResultsController::class, 'downloadPdf'])->name('results.download_pdf');
Route::get('/serve-pdf', [App\Http\Controllers\Landing\ResultsController::class, 'servePdf'])->name('results.serve_pdf');

Auth::routes(['register' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('years', App\Http\Controllers\Admin\YearController::class);
    Route::resource('result-types', App\Http\Controllers\ResultTypeController::class);
    Route::resource('levels', App\Http\Controllers\Admin\LevelController::class);
    Route::resource('regions', App\Http\Controllers\Admin\RegionController::class);
    Route::resource('schools', App\Http\Controllers\Admin\SchoolController::class);
    Route::resource('districts', App\Http\Controllers\Admin\DistrictController::class);
    Route::get('districts-by-region/{id}', [App\Http\Controllers\Admin\DistrictController::class, 'getByRegion'])->name('districts.by-region');
    Route::get('districts-bulk-create', [App\Http\Controllers\Admin\DistrictController::class, 'bulkCreateForm'])->name('districts.bulk-create-form');
    Route::post('districts/bulk-store', [App\Http\Controllers\Admin\DistrictController::class, 'bulkStore'])->name('districts.bulk-store');
    Route::post('districts/bulk-delete', [App\Http\Controllers\Admin\DistrictController::class, 'bulkDelete'])->name('districts.bulk-delete');
    Route::resource('result-summaries', App\Http\Controllers\Admin\ResultSummaryController::class);
    Route::post('result-summaries/bulk-delete', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkDelete'])->name('result-summaries.bulk-delete');
    Route::get('region-summaries/create', [App\Http\Controllers\Admin\ResultSummaryController::class, 'createRegion'])->name('region-summaries.create');
    Route::get('region-summaries/titles-by-region/{id}', [App\Http\Controllers\Admin\ResultSummaryController::class, 'getTitlesByRegion'])->name('region-summaries.titles-by-region');
    Route::get('region-summaries/districts-by-region/{id}', [App\Http\Controllers\Admin\ResultSummaryController::class, 'getDistrictsByRegion'])->name('region-summaries.districts-by-region');
    Route::post('region-summaries/store', [App\Http\Controllers\Admin\ResultSummaryController::class, 'storeRegion'])->name('region-summaries.store');
    Route::get('region-summaries/bulk', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkRegionForm'])->name('region-summaries.bulk-form');
    Route::post('region-summaries/bulk', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkRegionUpload'])->name('region-summaries.bulk-upload');
    Route::get('district-summaries/create', [App\Http\Controllers\Admin\ResultSummaryController::class, 'createDistrict'])->name('district-summaries.create');
    Route::get('district-summaries/titles-by-district/{id}', [App\Http\Controllers\Admin\ResultSummaryController::class, 'getTitlesByDistrict'])->name('district-summaries.titles-by-district');
    Route::post('district-summaries/store', [App\Http\Controllers\Admin\ResultSummaryController::class, 'storeDistrict'])->name('district-summaries.store');
    Route::get('district-summaries/bulk', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkDistrictForm'])->name('district-summaries.bulk-form');
    Route::post('district-summaries/bulk', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkDistrictUpload'])->name('district-summaries.bulk-upload');
    Route::post('result-titles/bulk-delete', [App\Http\Controllers\Admin\ResultTitleController::class, 'bulkDelete'])->name('result-titles.bulk-delete');
    Route::post('results/bulk-delete', [App\Http\Controllers\Admin\ResultController::class, 'bulkDelete'])->name('results.bulk-delete');
    Route::post('results/bulk-status', [App\Http\Controllers\Admin\ResultController::class, 'bulkStatus'])->name('results.bulk-status');
    Route::post('results/bulk-status-by-exam', [App\Http\Controllers\Admin\ResultController::class, 'bulkStatusByExam'])->name('results.bulk-status-by-exam');
    Route::get('bulk-summaries', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkUploadForm'])->name('result-summaries.bulk-upload-form');
    Route::post('bulk-summaries', [App\Http\Controllers\Admin\ResultSummaryController::class, 'bulkUpload'])->name('result-summaries.bulk-upload');
    Route::resource('result-titles', App\Http\Controllers\Admin\ResultTitleController::class);
    Route::resource('results', App\Http\Controllers\Admin\ResultController::class);
    Route::get('results-bulk-upload', [App\Http\Controllers\Admin\ResultController::class, 'bulkUploadForm'])->name('results.bulk-upload-form');
    Route::post('results/bulk-upload', [App\Http\Controllers\Admin\ResultController::class, 'bulkUpload'])->name('results.bulk-upload');
    Route::get('results-pc/create', [App\Http\Controllers\Admin\ResultController::class, 'createPc'])->name('results.pc-create');
    Route::post('results-pc/store', [App\Http\Controllers\Admin\ResultController::class, 'storePc'])->name('results.pc-store');
    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('admins', App\Http\Controllers\Admin\AdminManagementController::class);
});
