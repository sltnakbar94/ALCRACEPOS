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

Route::group(['prefix' => 'transaction-item','middleware' => ['client']], function () {
    Route::post('/store-transaction','APIController@storeTransaction');
    Route::post('/store-transaction-item','APIController@storeItem');
    Route::post('/store-transaction-cart','APIController@storeCart');
    Route::post('/store-transaction-refund','APIController@storeRefund');

    Route::post('/update-change','APIController@updateChangeTransaction');
    
    Route::delete('/destroy-transaction-cart/{id}','APIController@destroyCart');
    Route::post('/reduce-stock','APIController@reduceStock');
    Route::post('/restore-stock','APIController@restoreStock');
});