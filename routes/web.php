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

/**
 * Test Route
 */
Auth::routes(['register' => false, 'verify' => false, 'confirm' => false]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Bookings Route
 */
Route::get('/bookings', 'BookingController@index')->name('bookings');

/**
 * Admin Route (User management)
 */
Route::get('/admin/users', 'AdminController@showUsers')->name('admin.users');
Route::post('/admin/users', 'AdminController@createUser')->name('admin.create.user');
Route::put('/admin/user/{id}/edit', 'AdminController@editUser')->name('admin.edit.user');
Route::delete('/admin/user/{id}/delete', 'AdminController@deleteUser')->name('admin.delete.user');

/**
 * Reports Route
 */
Route::get('/report/{from}/{to}', 'ReportController@index');
Route::get('/report/{from}/{to}/download', 'ReportController@download');
// Route::get('/report/{month}/{year}', 'ReportController@showReportsMonthly');
// Route::get('/report/{year}', 'ReportController@showReportsAnnually');
