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
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/json','EmployeeController@json')->name('employeeJson');
        Route::get('/', 'EmployeeController@index')->name('employeeView');    
        
        Route::get('/create', 'EmployeeController@create')->name('employeeCreate');    
        Route::post('/store', 'EmployeeController@store')->name('employeeStore');    

        Route::get('/edit', 'EmployeeController@edit')->name('employeeEdit');    
        Route::patch('/update', 'EmployeeController@update')->name('employeeUpdate');    

        Route::delete('/destroy','EmployeeController@destroy')->name('employeeDelete');
    });
});
