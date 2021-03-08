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

Route::group(['prefix' => 'operator','middleware' => ['auth','role:staff|superadministrator|storemanager']], function () {
    Route::group(['prefix' => 'shift'], function () {
        Route::post('/open','ShiftController@store')->name('storeShift');
        Route::get('/close/','CloseShiftController@index')->name('formCloseShift');
        Route::post('/close/store','CloseShiftController@store')->name('closeShift');
        
        Route::group(['prefix' => 'report'], function () {
            Route::get('/json','ReportShiftController@json')->name('jsonShift');
            Route::get('/','ReportShiftController@index')->name('reportShift');
            Route::get('/close/show','ReportShiftController@show')->name('showShift');
            Route::get('/close/pdf','ReportShiftController@pdf')->name('printShift');
        });
        
    });
    Route::get('/close-shift','ShiftController@index')->name('successShift');
});