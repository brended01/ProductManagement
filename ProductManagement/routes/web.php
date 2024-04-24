<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorksController;
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

Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'get']);
    Route::delete('/products', [ProductController::class, 'destroy']);
    Route::post('/products', [ProductController::class, 'create']);
    Route::get('/price_list', [PriceListController::class, 'get']);
    Route::delete('/price_list', [PriceListController::class, 'destroy']);
    Route::post('/price_list', [PriceListController::class, 'create']);
    Route::get('/agencies', [AgencyController::class, 'get']);
    Route::delete('/agencies', [AgencyController::class, 'destroy']);
    Route::post('/agencies', [AgencyController::class, 'create']);
    Route::get('/works', [WorksController::class, 'get']);
    Route::delete('/works', [WorksController::class, 'destroy']);
    Route::post('/works', [WorksController::class, 'create']);
});


Route::get('/products', [ProductController::class, 'index']);

Route::get('/price_list', [PriceListController::class, 'index']);

Route::get('/agencies', [AgencyController::class, 'index']);

Route::get('/works', [WorksController::class, 'index']);
