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

Route::get('/', 'FileController@showUploadPage')->name('home');

Route::post('upload', 'FileController@processUpload');
Route::get('download/{fileuuid}/{filekey}','FileController@showDownloadPage')->name('downloadpage');
Route::get('download/do/{fileuuid}/{filekey}','FileController@processDownload')->name('processdownload');
Route::get('delete/{fileuuid}','FileController@userDeleteFile')->name('userDeleteFile');
require __DIR__ . '/auth.php';
