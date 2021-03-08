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

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('dashboard')->group(function() {
        Route::get('/', 'DashboardController@index');
        Route::post('/month', 'DashboardController@index');
    });
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/','StatisticController@index')->name('statistic');
    });
});
