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
    Route::prefix('transaction-ticket')->group(function() {
        Route::get('/json','TransactionTicketController@json')->name('transTicketJson');
        Route::get('/', 'TransactionTicketController@index')->name('transTicketView');
        Route::get('/show', 'TransactionTicketController@transShow')->name('transTicketDetail');

        Route::group(['prefix' => 'refund'], function () {
            Route::get('/','RefundController@index')->name('refundTicketView');
            Route::post('/store','RefundController@store')->name('refundTicketStore');
        });
    });
});
