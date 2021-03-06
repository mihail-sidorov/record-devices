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
Route::post('/admin/add-work-place', 'AdminController@addWorkPlace');
Route::post('/admin/add-component-part', 'AdminController@addComponentPart');
Route::post('/admin/add-worker', 'AdminController@addWorker');
Route::post('/admin/add-provider', 'AdminController@addProvider');
Route::post('/admin/add-responsible', 'AdminController@addResponsible');
Route::post('/admin/add-department', 'AdminController@addDepartment');
Route::post('/admin/add-category', 'AdminController@addCategory');
Route::post('/admin/del-device', 'AdminController@delDevice');
Route::post('/admin/del-work-place', 'AdminController@delWorkPlace');
Route::post('/admin/del-component-part', 'AdminController@delComponentPart');
Route::post('/admin/del-worker', 'AdminController@delWorker');
Route::post('/admin/del-provider', 'AdminController@delProvider');
Route::post('/admin/del-responsible', 'AdminController@delResponsible');
Route::post('/admin/del-department', 'AdminController@delDepartment');
Route::post('/admin/del-category', 'AdminController@delCategory');
Route::post('/admin/write-edit-device-form', 'AdminController@writeEditDeviceForm');
Route::post('/admin/write-edit-work-place-form', 'AdminController@writeEditWorkPlaceForm');
Route::post('/admin/write-edit-component-part-form', 'AdminController@writeEditComponentPartForm');
Route::post('/admin/write-edit-worker-form', 'AdminController@writeEditWorkerForm');
Route::post('/admin/write-edit-provider-form', 'AdminController@writeEditProviderForm');
Route::post('/admin/write-edit-responsible-form', 'AdminController@writeEditResponsibleForm');
Route::post('/admin/write-edit-department-form', 'AdminController@writeEditDepartmentForm');
Route::post('/admin/write-edit-category-form', 'AdminController@writeEditCategoryForm');
Route::post('/admin/edit-device', 'AdminController@editDevice');
Route::post('/admin/edit-work-place', 'AdminController@editWorkPlace');
Route::post('/admin/edit-component-part', 'AdminController@editComponentPart');
Route::post('/admin/edit-worker', 'AdminController@editWorker');
Route::post('/admin/edit-provider', 'AdminController@editProvider');
Route::post('/admin/edit-responsible', 'AdminController@editResponsible');
Route::post('/admin/edit-department', 'AdminController@editDepartment');
Route::post('/admin/edit-category', 'AdminController@editCategory');
Route::get('/admin/tab/{tab_name}', 'AdminController@index');
Route::post('/admin/attach-worker-to-device', 'AdminController@attachWorkerToDevice');
Route::post('/admin/attach-worker-to-work-place', 'AdminController@attachWorkerToWorkPlace');
Route::post('/admin/unattach-worker-from-device', 'AdminController@unattachWorkerFromDevice');
Route::post('/admin/unattach-worker-from-work-place', 'AdminController@unattachWorkerFromWorkPlace');
Route::post('/admin/write-attach-component-parts-modal-window', 'AdminController@writeAttachComponentPartsModalWindow');
Route::post('/admin/write-attach-devices-modal-window', 'AdminController@writeAttachDevicesModalWindow');
Route::post('/admin/attach-component-parts-to-work-place', 'AdminController@attachComponentPartsToWorkPlace');
Route::post('/admin/attach-devices-to-worker', 'AdminController@attachDevicesToWorker');
Route::post('/admin/get-free-workers-to-work-place', 'AdminController@getFreeWorkersToWorkPlace');
Route::post('/admin/get-workers-to-device', 'AdminController@getWorkersToDevice');
Route::post('/admin/change-password', 'AdminController@changePassword');

Route::post('/act/create-act', 'ActController@createAct');
Route::get('/act/{act_id}', 'ActController@index');
Route::post('/act/upload', 'ActController@upload');
Route::get('/act/download/{act_id}', 'ActController@download');
Route::post('/act/delete', 'ActController@delete');

Route::get('/worker', 'WorkerController@index')->name('worker');
Route::get('/worker/tab/{tab_name}', 'WorkerController@index');
Route::post('/worker/add-service', 'WorkerController@addService');
Route::post('/worker/write-edit-service-form', 'WorkerController@writeEditServiceForm');
Route::post('/worker/edit-service', 'WorkerController@editService');
Route::post('/worker/del-service', 'WorkerController@delService');