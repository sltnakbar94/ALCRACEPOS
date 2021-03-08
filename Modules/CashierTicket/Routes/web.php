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
    Route::prefix('cashier-ticket')->group(function() {
        // Route::get('/json','CashierItemController@json')->name('cashTicketJson');
        Route::get('/', 'CashierTicketController@index')->name('cashTicketView');

        Route::group(['prefix' => 'cart'], function () {
            Route::post('/pass','CashierTicketController@cartPass')->name('cashTicketCartPass');
            Route::post('/basic','CashierTicketController@cartBasic')->name('cashTicketCartBasic');
            Route::post('/cashback','CashierTicketController@cashback')->name('cashTicketCashback');
            Route::get('/remove','CashierTicketController@cartRemove')->name('cashTicketRemove');
            Route::post('/store','CashierTicketController@cartStore')->name('cashTicketStore');
            Route::get('/transaction-success','CashierTicketController@cartSuccess')->name('cashTicketSuccess');
            Route::get('/render-receipt','CashierTicketController@cartReceipt')->name('cashTicketReceipt');
            Route::get('/clear-cart', function () {
                Cart::destroy();
                return redirect()->back();
            })->name('cashTicketClear');
            Route::get('/cart-up','CashierTicketController@cartUp')->name('cashTicketCartUp');
        });
});
});
