<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PaymentController;


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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/upload/{id}', [UploadController::class, 'view'])->name('upload');
Route::post('/upload-submit', [UploadController::class, 'store'])->name('upload-submit');
Route::post('/pay', [PaymentController::class, 'pay']);
Route::get('/delete', [UploadController::class, 'delete'])->name('delete');