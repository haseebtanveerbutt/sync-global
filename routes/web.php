<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['middleware'=>['auth.shopify']], function () {

    Route::get('/', 'UserController@user_dashboard')->name('user-dashboard');
    Route::get('/import-data-info-page', 'UserController@import_data_info_page')->name('import-data-info-page');

    Route::post('/csv-upload', 'UserController@csv_upload')->name('csv-upload');
    Route::post('csv-mapped-field', 'UserController@csv_mapped_field')->name('csv-mapped-field');
    Route::post('url-mapped-field', 'UserController@url_mapped_field')->name('url-mapped-field');
    Route::post('import-via-url', 'UserController@import_via_url')->name('import-via-url');

    Route::get('/schedulers-list', 'SchedulerController@scheduler_list')->name('schedulers-list');
    Route::get('/schedulers', 'SchedulerController@scheduler_index')->name('schedulers');

    Route::get('/delete-scheduler{id}', 'SchedulerController@scheduler_delete')->name('delete-scheduler');
    Route::post('/scheduler-save', 'SchedulerController@scheduler_save')->name('scheduler-save');
    Route::post('scheduler-url-mapped-field', 'SchedulerController@scheduler_url_mapped_field')->name('scheduler-url-mapped-field');
//    Route::get('/import', 'ImportController@getImport')->name('import');
//    Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
//    Route::post('/import_process', 'ImportController@processImport')->name('import_process');
    Route::get('sync-api-products', 'ProductController@sync_api_products')->name('sync-api-products');

});
