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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/logout', function(){
    return redirect()->route('home');
});
Route::get('/password/email', function(){
    return redirect()->route('home');
});

Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/admin/add-device', 'AdminController@addDevice');

Route::get('/worker', 'WorkerController@index')->name('worker');