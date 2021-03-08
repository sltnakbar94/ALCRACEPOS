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
    Route::prefix('transaction-item')->group(function() {
        Route::get('/json','TransactionItemController@json')->name('transItemJson');
        Route::get('/', 'TransactionItemController@index')->name('transItemView');
        Route::get('/show', 'TransactionItemController@transShow')->name('transItemDetail');
        Route::get('/show-item','TransactionItemController@transShowItem')->name('transShowItem');
        Route::group(['prefix' => 'refund'], function () {
            Route::get('/','RefundController@index')->name('refundItemView');
            Route::post('/store','RefundController@store')->name('refundItemStore');
        });
    });
});
