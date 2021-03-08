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
Route::group(['prefix' => 'operator','middleware' => ['auth','role:storemanager|superadministrator']], function () {
    Route::group(['prefix' => 'wahana'], function () {
        Route::get('/json', 'WahanaController@json')->name('wahanaJson');
        Route::get('/', 'WahanaController@index')->name('wahanaView');

        Route::get('/create','WahanaController@create')->name('wahanaCreate'); 
        Route::post('/store','WahanaController@store')->name('wahanaStore');
        
        Route::get('/edit','WahanaController@edit')->name('wahanaEdit'); 
        Route::patch('/update','WahanaController@update')->name('wahanaUpdate');

        Route::delete('/destroy','WahanaController@destroy')->name('wahanaDestroy');

        Route::group(['prefix' => 'change-price'], function () {
            Route::get('/json','ChangePriceController@json')->name('changePriceWhJson');
            Route::get('/json-requested','ChangePriceController@jsonRequested')->name('changePriceWhRequestedJson');
            Route::get('/','ChangePriceController@index')->name('changePriceWhView');
            Route::get('/request','ChangePriceController@request')->name('changePriceWhForm');
            Route::post('/store','ChangePriceController@store')->name('changePriceWhStore');
        });
    });
    Route::group(['prefix' => 'counter'], function () {
        Route::get('/json','CounterController@json')->name('counterJson');
        Route::get('/','CounterController@index')->name('counterView');
        
        Route::get('/create','CounterController@create')->name('counterCreate');
        Route::post('/store','CounterController@store')->name('counterStore');

        Route::get('/edit','CounterController@edit')->name('counterEdit');
        Route::patch('/update','CounterController@update')->name('counterUpdate');

        Route::delete('/destroy','CounterController@destroy')->name('counterDestroy');
    });
});
Route::group(['prefix' => 'operator','middleware' => ['auth','role:superadministrator']], function () {
    Route::group(['prefix' => 'approval-price'], function () {
        Route::get('/json','ApprovalPriceController@json')->name('approvalWhJson');
        Route::get('/','ApprovalPriceController@index')->name('approvalWhView');
        Route::get('/show','ApprovalPriceController@show')->name('approvalWhShow');
        Route::get('/store','ApprovalPriceController@store')->name('approvalWhStoreGet');
        Route::post('/store','ApprovalPriceController@store')->name('approvalWhStorePost');
    });
});

