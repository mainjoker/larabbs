<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/3
 * Time: 16:05
 */

namespace App\Http\Service\Api;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class VerificationService
{
    public function store($request)
    {
        $res = send_sms($request->phone);
        if ($res['success']) {
            $key = 'verificationCode_' . Str::random(15);
            $expireAt = now()->addMinutes(5);//5分钟有效
            Cache::put($key, ['code' => $res['code'], 'phone' => $request->phone], $expireAt);
            return response()->json([
                'key' => $key,
                'expireAt' => $expireAt->toDateTimeString()
            ])->setStatusCode(201);
        } else {
            $message = $res['msg'];
            abort(500, $message ?: '短信发送异常');
        }
    }
}