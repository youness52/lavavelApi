<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\ProductController;
/* Put it at the top */
use App\Http\Controllers\CategoryController;



//Auth::routes();
/* Put it at the top */
//Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
// Route::group(['prefix' => 'categories', 'as' => 'categories.'], function(){
// 	Route::controller(CategoryController::class)->group(function () {
// 		Route::get('', 'index')->name('index');
// 		Route::get('list', 'list')->name('list');
// 		Route::post('save/{id?}', 'save')->name('save');
// 		Route::get('find/{id?}', 'find')->name('find');
// 		Route::get('delete/{id?}', 'delete')->name('delete');
// 	});
// });
// Route::group(['prefix' => 'products', 'as' => 'products.'], function(){
// 	Route::controller(ProductController::class)->group(function () {
// 		Route::get('', 'index')->name('index');
// 		Route::get('list', 'list')->name('list');
//         Route::get('create', 'create')->name('create');
// 		Route::post('save/{id?}', 'save')->name('save');
// 		Route::get('find/{id?}', 'find')->name('find');
// 		Route::get('delete/{id?}', 'delete')->name('delete');
// 	});
// });
// //});
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return redirect()->intended('/login');;
// });
