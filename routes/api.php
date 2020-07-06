<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('accounts', 'Api\Account\AccountController@store');
Route::post('login', 'Api\Auth\AuthController@login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('accounts/balance', 'Api\Account\AccountController@balance');
    Route::post('accounts/deposit', 'Api\Account\AccountController@deposit');
    Route::post('accounts/withdraw', 'Api\Account\AccountController@withdraw');
});
