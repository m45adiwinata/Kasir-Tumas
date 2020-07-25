<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'WelcomeController@index');

Route::resource('/stok', StokController::class);
Route::get('/stok/masuk/{data}', 'StokController@masuk');
Route::get('/stok/get-data/{barcode}', 'StokController@getData');
Route::get('/stok/update/{barcode}', 'StokController@update2');
Route::get('/stok/get-by-nama/{nama}', 'StokController@getByNama');
Route::resource('/penjualan', PenjualanController::class);
Route::get('/admin', 'AdminController@index');
Route::get('/admin/rekap/{tgl1}/{tgl2}', 'AdminController@rekapHarian');