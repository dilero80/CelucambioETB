<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'FrontPagesController@index');
Route::get('etb/cambiar/1', function() {
    return redirect('/');
});

Route::get('brand/{id}/devices/all/', 'BrandsController@getAllBrandDevices');
Route::get('brand/{id}/devices/names/', 'BrandsController@getBrandDevicesNames');
Route::get('device/{id}/details/', 'DevicesController@getDeviceDetails');

Route::get('login', function() {
    return redirect('/ingresar');
});
Route::get('ingresar/{redirect?}', 'Auth\LoginController@showLogin');
Route::post('login', 'Auth\LoginController@postLogin');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('registro', 'Auth\RegisterController@showSignup');
Route::post('signup', 'Auth\RegisterController@signup');

Route::get('recuperar-cuenta', 'Auth\ForgotPasswordController@showRecoverForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('complete-order', 'OrdersController@createOrder');

Route::group(['prefix' => 'usuario', 'middleware' => ['auth:customer']], function() {
    Route::get('/dashboard/{transaction?}', [
        'as' => 'dashboardETB', 'uses' => 'OrdersController@orders'
    ]);
    Route::get('/checkout/{order}', 'PaymentsController@checkout');
    Route::get('/order/complete/{refCode}/{state}', 'PaymentsController@finishPSE');
    Route::post('/processpayu', 'PaymentsController@processPayURequest');
    Route::get('/process-result', 'PaymentsController@processResultPSE');
    Route::get('/show-result/{refCode}', 'PaymentsController@showResultPSE');

    Route::get('/contraentrega/{order}', 'OrdersController@onDeliver');
    Route::post('/processondeliver', 'OrdersController@processOnDeliver');
    Route::post('/order', 'OrdersController@orderDetail');
});
