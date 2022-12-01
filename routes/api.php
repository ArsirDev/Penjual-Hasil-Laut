<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login'); 

Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register'); 

Route::get('profil', [App\Http\Controllers\ProfileController::class, 'profil'])->name('profil'); 


// Input
Route::post('insert-hasil', [App\Http\Controllers\HasilLautController::class, 'insert'])->middleware('auth:api');

Route::get('detail', [App\Http\Controllers\HasilLautController::class, 'detail']);

// Search
Route::get('index',[App\Http\Controllers\SearchController::class, 'index']);

Route::get('search',[App\Http\Controllers\SearchController::class, 'search']);

// Xendit
Route::get('xendit/va/list',[App\Http\Controllers\XenditController::class, 'getListVa']);

Route::get('xendit/va/invoice',[App\Http\Controllers\XenditController::class, 'createVa']);

Route::post('xendit/va/callback',[App\Http\Controllers\XenditController::class, 'callbackVa']);


// Keranjang
Route::post('set-cart', [App\Http\Controllers\KeranjangController::class, 'setKeranjang'])->middleware('auth:api');

Route::get('get-cart', [App\Http\Controllers\KeranjangController::class, 'getKeranjang']);

Route::get('delete-item-cart', [App\Http\Controllers\KeranjangController::class, 'deleteKeranjangById']);

Route::get('delete-cart', [App\Http\Controllers\KeranjangController::class, 'deleteKeranjang']);

// Notification
Route::post('save-token', [App\Http\Controllers\NotificationController::class, 'saveToken'])->middleware('auth:api');

Route::get('get-token', [App\Http\Controllers\NotificationController::class, 'getToken'])->name('get-token');

Route::post('send-notification', [App\Http\Controllers\NotificationController::class, 'sendNotification'])->name('send-notification');

// Transaksi
Route::get('get-transaksi', [App\Http\Controllers\TransactionController::class, 'getTransaksi'])->middleware('auth:api');

Route::post('transaksi', [App\Http\Controllers\TransactionController::class, 'transaksi'])->middleware('auth:api');
