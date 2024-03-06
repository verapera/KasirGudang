<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' =>'auth'],function(){
    Route::get('/', function () {
        return view('index');
    });
    
    
    Route::controller(ProdukController::class)->group(function(){
        Route::get('/produk','index')->name('produk');
        Route::post('/addproduk','create')->name('addproduk');
        Route::delete('/deleteproduk/{produk_id}','delete')->name('deleteproduk');
        Route::get('/update/{produk_id}','showupdate')->name('update');
        Route::put('/processupdate/{produk_id}','update')->name('processupdate');
    });
    Route::controller(PelangganController::class)->group(function(){
        Route::get('/pelanggan','index')->name('pelanggan');
        Route::post('/addpelanggan','create')->name('addpelanggan');
        Route::delete('/deletepelanggan/{pelanggan_id}','delete')->name('deletepelanggan');
    });
    Route::controller(PenjualanController::class)->group(function(){
        Route::get('/penjualan','index')->name('penjualan');
        Route::get('/transaksi/{pelanggan_id}','transaksi')->name('transaksi');
        Route::post('/tambahkeranjang/{pelanggan_id}','tambahkeranjang')->name('tambahkeranjang');
        Route::post('/bayar/{kode_penjualan}','bayar')->name('bayar');
        Route::get('/invoice/{kode_penjualan}','invoice')->name('invoice');
        Route::delete('/deletekeranjang/{detail_id}','deletekeranjang')->name('deletekeranjang');
        Route::get('/report/{kode_penjualan}','report')->name('report');
    });
    Route::controller(PenggunaController::class)->middleware('admin')->group(function(){
        Route::get('/pengguna','index')->name('pengguna');
        Route::post('/addpengguna','create')->name('addpengguna');
        Route::delete('/deletepengguna/{pelanggan_id}','delete')->name('deletepengguna');
    });
});
Route::controller(AuthController::class)->group(function(){
    Route::get('/login','showlogin')->name('login');
    Route::post('/login','login');
    Route::get('/logout','logout')->name('logout');
});


