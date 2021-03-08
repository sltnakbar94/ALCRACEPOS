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
Route::group(['prefix' => 'operator','middleware' => ['auth','role:superadministrator']], function () {
    Route::prefix('best-selling')->group(function() {
        Route::prefix('wahana')->group(function() {
            Route::get('/json','BestSellingController@wahanaJson')->name('reportBestSellingWahanaJson');
            Route::get('/','BestSellingController@wahana')->name('reportBestSellingWahana');
        });
        Route::prefix('item')->group(function() {
            Route::get('/json','BestSellingController@itemJson')->name('reportBestSellingItemJson');
            Route::get('/','BestSellingController@item')->name('reportBestSellingItem');
        });
    });
    Route::group(['prefix' => 'item-selling','namespace' => 'ItemSelling'], function () {
        Route::get('/json','SalesProfitController@itemJson')->name('reportProfitItemJson');
        Route::get('/','SalesProfitController@index')->name('reportProfitItem');
    });
});
