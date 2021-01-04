<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;


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

Auth::routes();


Route::middleware('can:member')->group(function() {
    \Log::debug(print_r('スタッフの方', true));
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/upload/{id}', [UploadController::class, 'view'])->name('upload');
    Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');
    Route::post('/pay', [PaymentController::class, 'pay']);
    Route::get('/delete', [UploadController::class, 'delete'])->name('delete');
});

Route::middleware('can:admin')->group(function() {
    \Log::debug(print_r('管理者の方', true));
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home');
    Route::get('/upload/{id}', [UploadController::class, 'view'])->name('upload');
    Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');
    Route::post('/pay', [PaymentController::class, 'pay']);
    Route::get('/delete', [UploadController::class, 'delete'])->name('delete');
});
