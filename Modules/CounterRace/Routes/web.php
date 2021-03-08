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
Route::group(['prefix' => 'operator','middleware' => ['auth','role:staff']], function () {
    Route::prefix('counter-race')->group(function() {
        Route::get('/', 'CounterRaceController@index')->name('counterRace');
        Route::get('/start','CounterRaceController@start')->name('counterRaceStart');
        Route::get('/reset','CounterRaceController@reset')->name('counterRaceReset');
    });
});
