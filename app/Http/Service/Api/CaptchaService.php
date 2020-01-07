<?php

namespace App\Http\Service\Api;
class CaptchaService extends BaseService
{
    public function store($request, $builder)
    {
        $key = 'captcha_' . \Illuminate\Support\Str::random(15);
        $phone = $request->phone;
        $captcha = $builder->build();
        $expiredAt = now()->addMinutes(5);
        \Illuminate\Support\Facades\Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);
        $res = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];
        return response()->json($res)->setStatusCode(201);
    }
}