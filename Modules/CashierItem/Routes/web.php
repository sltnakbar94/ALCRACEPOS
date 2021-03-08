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
    Route::group(['prefix' => 'cashier-item'], function () {
        Route::get('/json', 'CashierItemController@json')->name('cashItemJson');
        Route::get('/', 'CashierItemController@index')->name('cashItemView');
        
        Route::group(['prefix' => 'cart'], function () {
            Route::post('/','CashierItemController@cart')->name('cashItemCart');
            Route::post('/update','CashierItemController@cartUpdate')->name('cashItemCartUpdate');
            Route::get('/cart-up','CashierItemController@cartUp')->name('cartItemCartUp');
            Route::get('/cart-down','CashierItemController@cartDown')->name('cartItemCartDown');
            Route::get('/remove','CashierItemController@cartRemove')->name('cashItemRemove');
            Route::post('/store','CashierItemController@cartStore')->name('cashItemStore');
            Route::get('/transaction-success','CashierItemController@cartSuccess')->name('cashItemSuccess');
            // Route::get('/render-receipt',['middleware' => ['role:staff|superadminstrator|storemanager'],'uses' => 'CashierItemController@cartReceipt'])->name('cashItemReceipt');
            Route::get('/render-receipt','CashierItemController@cartReceipt')->name('cashItemReceipt');
        });
    });
});
