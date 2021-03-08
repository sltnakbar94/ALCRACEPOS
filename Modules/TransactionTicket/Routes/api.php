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

// Route::group(['middleware' => ['client'],'prefix' => 'transaction-ticket'], function () {
Route::group(['prefix' => 'transaction-ticket'], function () {
    Route::post('/store-transaction','APIController@storeTransaction')->name('storeTransaction');
    Route::post('/store-transaction-item','APIController@storeItem')->name('storeItem');
    Route::post('/store-transaction-cart','APIController@storeCart')->name('storeCart');
    Route::post('/store-transaction-refund','APIController@storeRefund')->name('storeRefund');

    Route::post('/update-change','APIController@updateChangeTransaction');
    
    Route::delete('/destroy-transaction-cart/{id}','APIController@destroyCart')->name('destroyCart');
});