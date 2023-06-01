<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\StatusPemesananController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\HistoriPemesananController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout',  [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::post('register', [RegisterController::class, 'register']);

});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [AuthController::class, 'me']);

    //produk
    Route::get('produk', [ProdukController::class, 'index']);
    Route::post('produk', [ProdukController::class, 'create']);
    Route::post('produk/{id}', [ProdukController::class, 'update']);
    Route::delete('produk/{id}', [ProdukController::class, 'delete']);
    Route::get('produk/paket_id/{id}', [ProdukController::class, 'getProdukByPaketId']);

    //paket
    Route::get('paket', [PaketController::class, 'index']);
    Route::post('paket', [PaketController::class, 'create']);
    Route::put('paket/{id}', [PaketController::class, 'update']);
    Route::delete('paket/{id}', [PaketController::class, 'delete']);

    //status
    Route::get('status', [StatusPemesananController::class, 'index']);
    Route::post('status', [StatusPemesananController::class, 'create']);
    Route::put('status/{id}', [StatusPemesananController::class, 'update']);
    Route::delete('status/{id}', [StatusPemesananController::class, 'delete']);

    //paket
    Route::get('pemesanan', [PemesananController::class, 'index']);
    Route::post('pemesanan', [PemesananController::class, 'create']);
    Route::put('pemesanan/{id}', [PemesananController::class, 'update']);
    Route::delete('pemesanan/{id}', [PemesananController::class, 'delete']);

    //history
    Route::get('history', [HistoriPemesananController::class, 'index']);
    Route::post('history', [HistoriPemesananController::class, 'create']);
    Route::put('history/{id}', [HistoriPemesananController::class, 'update']);
    Route::delete('history/{id}', [HistoriPemesananController::class, 'delete']);
});