<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\RankingController;

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
    return view('top/top');
});
// Route::get('/', function () {
//     return view('test');
// });

Auth::routes();

    Route::get('/home', [RankingController::class, 'index'])->name('home');
    Route::get('/upload/{id}', [UploadController::class, 'view'])->name('upload');
    Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');
    Route::post('/pay', [PaymentController::class, 'pay']);
    Route::get('/delete', [UploadController::class, 'delete'])->name('delete');

    Route::post('/user-search', [AdminHomeController::class, 'search'])->name('user-search');
    Route::get('/approval', [ApprovalController::class, 'view'])->name('approval');
    Route::post('/approval-search', [ApprovalController::class, 'search'])->name('approval-search');
    Route::get('/approval-update', [ApprovalController::class, 'update'])->name('approval-update');
    Route::get('/approval-delete', [ApprovalController::class, 'delete'])->name('approval-delete');

    Route::get('/fishing-results', [HomeController::class, 'index'])->name('fishing-results');
    Route::get('/admin-fishing-results', [AdminHomeController::class, 'index'])->name('admin-fishing-results');
