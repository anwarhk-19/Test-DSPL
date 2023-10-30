<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AjaxProductController;
use App\Http\Controllers\XmlReaderController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dailer', function () {
    return view('dailer.index');
})->name('dailer');

Route::resource('products', ProductController::class);
Route::resource('products-ajax-action', AjaxProductController::class);
Route::get('xml-data-save', [XmlReaderController::class, "generatePDFFromXML"]);