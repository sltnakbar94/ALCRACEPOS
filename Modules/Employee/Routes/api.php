<?php

use Illuminate\Http\Request;

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

// Route::group(['middleware' => ['client'],'prefix' => 'employee'], function () {
Route::group(['prefix' => 'employee'], function () {
    Route::get('/','APIController@index')->name('apiEmployee');
    Route::get('/role','APIController@role')->name('apiEmployeeRole');
});