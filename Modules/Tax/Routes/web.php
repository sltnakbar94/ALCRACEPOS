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

Route::group(['prefix' => 'operator'], function () {
    Route::prefix('tax')->group(function() {
        Route::get('/', 'TaxController@index')->name('opTax');
        Route::post('/', 'TaxController@store')->name('opTaxStore');
        Route::get('report','TaxController@report')->name('opTaxReport');
    });
});
