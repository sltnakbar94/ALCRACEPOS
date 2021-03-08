<?php

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

Route::prefix('changepassword')->group(function() {
    Route::get('/', 'ChangePasswordController@index')->name('changeUserPass');
    Route::post('/store', 'ChangePasswordController@store')->name('storeUserPass');
});
