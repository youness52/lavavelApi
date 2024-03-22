<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
/* Put it at the top */
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//header('Access-Control-Allow-Origin: *'); 
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function(){
        Route::controller(CategoryController::class)->group(function () {
            //Route::get('', 'index')->name('index');
            Route::get('list', 'list')->name('list');
            Route::post('save/{id?}', 'save')->name('save');
            Route::get('find/{id?}', 'find')->name('find');
            Route::get('delete/{id?}', 'delete')->name('delete');
        });
    });

    Route::group(['prefix' => 'products', 'as' => 'products.'], function(){
        Route::controller(ProductController::class)->group(function () {
            //Route::get('', 'index')->name('index');
            Route::get('list', 'list')->name('list');
            Route::get('create', 'create')->name('create');
            Route::post('save/{id?}', 'save')->name('save');
            Route::get('find/{id?}', 'find')->name('find');
            Route::get('delete/{id?}', 'delete')->name('delete');
        });
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });
    });

});

  




Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
	Route::controller(AuthController::class)->group(function () {
		Route::post('save', 'save')->name('save');
        Route::post('login', 'login')->name('login');
	});
});