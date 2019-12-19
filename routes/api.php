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

/**
 * Bookings API
 */
Route::get('/bookings', 'BookingController@show');
Route::post('/bookings', 'BookingController@store');
Route::put('/bookings', 'BookingController@update');
Route::put('/booking/checkout', 'BookingController@checkout');
Route::delete('/bookings', 'BookingController@destroy');

