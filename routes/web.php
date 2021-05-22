<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventSearchController;
use App\Http\Controllers\EventInfoController;
use App\Http\Controllers\EventEntry\EventEntryController;
use App\Http\Controllers\EventEntry\Admin\EventEntryController as EventEntryAdminController;
use App\Http\Controllers\ApprovalController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('profile');
Route::post('/profile-search-pull/{id}', [ProfileController::class, 'searchPull'])->name('profile-search-pull');
Route::post('/profile-update/{id}', [ProfileController::class, 'update'])->name('profile-update');
Route::post('/profile-update-image', [ProfileController::class, 'updateImage'])->name('profile-update-image');

Route::get('/upload/{id}', [UploadController::class, 'view'])->name('upload');
Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');

Route::get('/event-management/{id}', [EventManagementController::class, 'view'])->name('event-management');

Route::get('/event-registration/{id}', [EventRegistrationController::class, 'view'])->name('event-registration');
Route::post('/event-submit', [EventRegistrationController::class, 'store'])->name('event-submit');

Route::get('/event-search', [EventSearchController::class, 'view'])->name('event-search');
Route::post('/event-search-submit', [EventSearchController::class, 'search'])->name('event-search-submit');

Route::get('/event-info/{id}', [EventInfoController::class, 'view'])->name('event-info');

Route::get('/event-entry/{id}', [EventEntryController::class, 'view'])->name('event-entry');
Route::get('/event-entry-admin/{id}', [EventEntryAdminController::class, 'view'])->name('event-entry-admin');
Route::get('/entry/{id}', [EventEntryController::class, 'entry'])->name('entry');

Route::get('/approval/{id}', [ApprovalController::class, 'view'])->name('approval');
Route::post('/approval-search/{id}', [ApprovalController::class, 'search'])->name('approval-search');
Route::get('/approval-update/{id}', [ApprovalController::class, 'update'])->name('approval-update');
