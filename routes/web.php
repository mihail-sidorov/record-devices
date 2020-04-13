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
Route::post('/admin/add-worker', 'AdminController@addWorker');
Route::post('/admin/add-provider', 'AdminController@addProvider');
Route::post('/admin/add-responsible', 'AdminController@addResponsible');
Route::post('/admin/add-department', 'AdminController@addDepartment');
Route::post('/admin/del-device', 'AdminController@delDevice');
Route::post('/admin/del-worker', 'AdminController@delWorker');
Route::post('/admin/del-provider', 'AdminController@delProvider');
Route::post('/admin/del-responsible', 'AdminController@delResponsible');
Route::post('/admin/del-department', 'AdminController@delDepartment');
Route::post('/admin/write-edit-device-form', 'AdminController@writeEditDeviceForm');
Route::post('/admin/write-edit-worker-form', 'AdminController@writeEditWorkerForm');
Route::post('/admin/write-edit-provider-form', 'AdminController@writeEditProviderForm');
Route::post('/admin/write-edit-responsible-form', 'AdminController@writeEditResponsibleForm');
Route::post('/admin/write-edit-department-form', 'AdminController@writeEditDepartmentForm');
Route::post('/admin/edit-device', 'AdminController@editDevice');
Route::post('/admin/edit-worker', 'AdminController@editWorker');
Route::post('/admin/edit-provider', 'AdminController@editProvider');
Route::post('/admin/edit-responsible', 'AdminController@editResponsible');
Route::post('/admin/edit-department', 'AdminController@editDepartment');
Route::get('/admin/tab/{tab_name}', 'AdminController@index');
Route::post('/admin/attach-worker', 'AdminController@attachWorker');
Route::post('/admin/unattach-worker', 'AdminController@unattachWorker');

Route::get('/worker', 'WorkerController@index')->name('worker');