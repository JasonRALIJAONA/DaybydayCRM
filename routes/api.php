<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\InvoiceController;

Route::post('login', [AuthController::class, 'login']);


// Route::get('dashboard', [DashboardController::class, 'index']);

Route::group(['namespace' => 'App\Api\v1\Controllers'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('users', ['uses' => 'UserController@index']);
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        // Route::get('users', ['uses' => 'UserController@index']);
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('payments', [PaymentController::class, 'index']);
        Route::delete('payments/{id}', [PaymentController::class, 'delete']);
        Route::put('payments/{id}', [PaymentController::class, 'update']);
        Route::get('payments/{id}', [PaymentController::class, 'show']);
        Route::get('discounts/{id}', [DiscountController::class, 'show']);
        Route::put('discounts/{id}', [DiscountController::class, 'update']);
        Route::get('offers', [OfferController::class, 'index']);
        Route::get('tasks', [TaskController::class, 'index']);
        Route::get('invoice-lines', [InvoiceController::class, 'index']);
    });
});
