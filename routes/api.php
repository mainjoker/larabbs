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
Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function (){
    Route::post('verificationCodes','VerificationCodesController@store')->name('verificationCodes.store');//发送短信验证码
    Route::post('users','UserController@store')->name('users.store');//用户注册
});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
