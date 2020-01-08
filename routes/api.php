<?php

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
    Route::middleware('throttle:'.config('my.rate_limits.sign'))->group(function (){
        Route::post('verificationCodes','VerificationCodesController@store')->name('verificationCodes.store');//发送短信验证码
        Route::post('users','UserController@store')->name('users.store');//用户注册
        Route::post('captchas', 'CaptchasController@store')->name('captchas.store');//图形验证码
    });
    //第三方登录
    //注意这里的参数，我们对 social_type 进行了限制，只会匹配 weixin，如果你增加了其他的第三方登录，可以再这里增加限制，例如支持微信及微博：->where('social_type', 'weixin|weibo') 。
    Route::post('socials/{social_type}/authorizations','AuthorizationsController@SocialStore')->where('social_type','weixin')->name('socials.authorizations.store');
    Route::get('socials/{social_type}/code','AuthorizationsController@getCode')->where('social_type','weixin')->name('socials.authorizations.code');
    Route::post('authorizations','AuthorizationsController@store')->name('authorizations.store');
    //刷新token
    Route::put('authorizations/current','AuthorizationsController@update')->name('authorizations.update');
    Route::delete('authorizations/current','AuthorizationsController@destroy')->name('authorizations.destroy');//删除token
    Route::get('users/{user}','UserController@show')->name('users.show');
    //登录后可访问的接口
    Route::middleware('auth:api')->group(function (){
        Route::get('user','UserController@me')->name('user.show');
    });


});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
