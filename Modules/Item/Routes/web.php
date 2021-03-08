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
    Route::group(['prefix' => 'item'], function () {
        Route::get('/json','ItemController@json')->name('itemJson');
        
        Route::get('/', 'ItemController@index')->name('itemView');

        Route::get('/generate-code','ItemController@generateCode')->name('generateCodeItem');

        Route::get('/create','ItemController@create')->name('itemCreate');
        Route::post('/store','ItemController@store')->name('itemStore');

        Route::get('/edit','ItemController@edit')->name('itemEdit');
        Route::patch('/update','ItemController@update')->name('itemUpdate');
        Route::delete('/destroy','ItemController@destroy')->name('itemDestroy');

        Route::get('/barcode','ItemController@barcode')->name('itemBarcode');

        Route::group(['prefix' => 'stock'], function () {
            Route::get('/json','StockController@json')->name('stockJson');
            Route::get('/','StockController@index')->name('stockView');
        });
        Route::group(['prefix' => 'change-price'], function () {
            Route::get('/json','ChangePriceController@json')->name('changePriceJson');
            Route::get('/json-requested','ChangePriceController@jsonRequested')->name('changePriceRequestedJson');
            Route::get('/','ChangePriceController@index')->name('changePriceView');
            Route::get('/request','ChangePriceController@request')->name('changePriceForm');
            Route::post('/store','ChangePriceController@store')->name('changePriceStore');
        });
        
        Route::group(['prefix' => 'receiving'], function () {
            Route::get('/json','ReceivingItemController@json')->name('receivingJson');
            Route::get('/json-log','ReceivingItemController@jsonLog')->name('receivingJsonLog');
            Route::get('/','ReceivingItemController@index')->name('receivingView');
            Route::get('/create','ReceivingItemController@create')->name('receivingForm');
            Route::post('/store','ReceivingItemController@store')->name('receivingStore');
        });
    });
});
Route::group(['prefix' => 'operator','middleware' => ['auth','role:superadministrator']], function () {
    Route::group(['prefix' => 'item'], function () {
        Route::group(['prefix' => 'approval-price'], function () {
            Route::get('/json','ApprovalPriceController@json')->name('approvalItemJson');
            Route::get('/','ApprovalPriceController@index')->name('approvalItemView');
            Route::get('/show','ApprovalPriceController@show')->name('approvalItemShow');
            Route::get('/store','ApprovalPriceController@store')->name('approvalItemStoreGet');
            Route::post('/store','ApprovalPriceController@store')->name('approvalItemStorePost');
        });
    });
});


