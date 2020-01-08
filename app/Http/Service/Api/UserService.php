<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/3
 * Time: 15:28
 */

namespace App\Http\Service\Api;


use App\Http\Resources\UserResource;
use App\Models\Images;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;

class UserService extends BaseService
{
    /**
     * @param $request
     * @return UserResource
     * @throws AuthenticationException
     */
    public function store($request)
    {
        $verifyData = Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => $request->password,
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return new UserResource($user);
    }

    public function update($request)
    {
        $user = $request->user();

        $attributes = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Images::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }
//        dd($attributes);
        $user->update($attributes);

        return (new UserResource($user))->showSensitiveFields();
    }
}