<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Upload\UploadController;
use App\Http\Controllers\Upload\Admin\UploadController as UploadAdminController;

use App\Http\Controllers\EventManagementController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventSearchController;
use App\Http\Controllers\EventInfoController;
use App\Http\Controllers\EventEntry\EventEntryController;
use App\Http\Controllers\EventEntry\Admin\EventEntryController as EventEntryAdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ChatController;

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
Route::get('/profile', [ProfileController::class, 'view']);
Route::post('/profile-search-pull/{id}', [ProfileController::class, 'searchPull'])->name('profile-search-pull');
Route::post('/profile-update/{id}', [ProfileController::class, 'update'])->name('profile-update');
Route::post('/profile-update-image', [ProfileController::class, 'updateImage'])->name('profile-update-image');
Route::get('/meaningful/{id}', [ProfileController::class, 'meaningful'])->name('meaningful');
Route::get('/meaningful-release/{id}', [ProfileController::class, 'meaningfulRelease'])->name('meaningful-release');

Route::get('/upload-top/{id}', [UploadController::class, 'view'])->name('upload-top');
Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');
Route::get('/upload-top-admin/{id}', [UploadAdminController::class, 'view'])->name('upload-top-admin');
Route::post('/upload-submit-admin', [UploadAdminController::class, 'store'])->name('upload-submit-admin');

Route::get('/event-management/{id}', [EventManagementController::class, 'view'])->name('event-management');

Route::get('/event-registration/{id}', [EventRegistrationController::class, 'view'])->name('event-registration');
Route::post('/event-submit', [EventRegistrationController::class, 'store'])->name('event-submit');

Route::get('/event-search', [EventSearchController::class, 'view'])->name('event-search');
Route::get('/event-search-submit', [EventSearchController::class, 'search'])->name('event-search-submit');
Route::post('/event-search-submit', [EventSearchController::class, 'search'])->name('event-search-submit');

Route::get('/event-info/{id}', [EventInfoController::class, 'view'])->name('event-info');
Route::get('/event-info-general/{id}', [EventInfoController::class, 'viewGeneral'])->name('event-info-general');
Route::get('/event-info-delete/{id}', [EventInfoController::class, 'delete'])->name('event-info-delete');

Route::get('/event-entry/{id}', [EventEntryController::class, 'view'])->name('event-entry');
Route::get('/event-result-delete/{id}', [EventEntryController::class, 'delete'])->name('event-result-delete');
Route::get('/event-entry-admin/{id}', [EventEntryAdminController::class, 'view'])->name('event-entry-admin');
Route::get('/event-result-delete-admin/{id}', [EventEntryAdminController::class, 'delete'])->name('event-result-delete-admin');
Route::get('/entry/{id}', [EventEntryController::class, 'entry'])->name('entry');

Route::get('/approval/{id}', [ApprovalController::class, 'view'])->name('approval');
Route::post('/approval-search/{id}', [ApprovalController::class, 'search'])->name('approval-search');
Route::get('/approval-update/{id}', [ApprovalController::class, 'update'])->name('approval-update');

Route::get('/chat', [ChatController::class, 'view'])->name('chat');
Route::post('/chat-send', [ChatController::class, 'send'])->name('chat-send');
