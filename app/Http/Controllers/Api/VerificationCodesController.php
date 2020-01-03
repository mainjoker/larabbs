<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodesRequest $request)
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
