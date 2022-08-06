<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\UserController;
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
Route::group(['middleware'=>['verify.shopify']], function () {

    Route::get('/', [UserController::class,'user_dashboard'])->name('home');
    Route::get('/import-data-info-page', [UserController::class,'import_data_info_page'])->name('import-data-info-page');

    Route::post('/csv-upload', [UserController::class,'csv_upload'])->name('csv-upload');
    Route::post('csv-mapped-field', [UserController::class,'csv_mapped_field'])->name('csv-mapped-field');
    Route::post('url-mapped-field', [UserController::class,'url_mapped_field'])->name('url-mapped-field');
    Route::post('import-via-url', [UserController::class,'import_via_url'])->name('import-via-url');

    Route::get('/schedulers-list', [SchedulerController::class,'scheduler_list'])->name('schedulers-list');
    Route::get('/schedulers', [SchedulerController::class,'scheduler_index'])->name('schedulers');

    Route::get('/delete-scheduler{id}', [SchedulerController::class,'scheduler_delete'])->name('delete-scheduler');
    Route::get('/scheduler-edit{id}', [SchedulerController::class,'scheduler_edit'])->name('scheduler-edit');
    Route::post('/edit-scheduler-save{id}', [SchedulerController::class,'edit_scheduler_save'])->name('edit-scheduler-save');

    Route::post('/scheduler-save', [SchedulerController::class,'scheduler_save'])->name('scheduler-save');
    Route::post('scheduler-url-mapped-field', [SchedulerController::class,'scheduler_url_mapped_field'])->name('scheduler-url-mapped-field');
    Route::post('edited-scheduler-url-mapped-field{id}', [SchedulerController::class,'edited_scheduler_url_mapped_field'])->name('edited-scheduler-url-mapped-field');
//    Route::get('/import', [ImportController::class,'getImport'])->name('import');
//    Route::post('/import_parse', [ImportController::class,'parseImport'])->name('import_parse');
//    Route::post('/import_process', [ImportController::class,'processImport'])->name('import_process');
    Route::get('sync-api-products', [ProductController::class,'sync_api_products'])->name('sync-api-products');

});
