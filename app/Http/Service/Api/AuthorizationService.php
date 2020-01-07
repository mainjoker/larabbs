<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/6
 * Time: 10:11
 */

namespace App\Http\Service\Api;


use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthorizationService extends BaseService
{
    //第三方登录
    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function SocialStore($request)
    {
        $type = $request->social_type;
        try {
            if ($type == 'weixin') {
                $driver = Socialite::driver('weixin');
                $driver->stateless();
                $oauthUser = $driver->user();
            }
        } catch (\Exception $e) {
            throw new AuthenticationException('获取用户信息失败');
        }
        switch ($type) {
            case 'weixin':
                if ($unionId = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null) {
                    $where['weixin_unionid'] = $unionId;
                } else {
                    $where['weixin_openid'] = $oauthUser->getId();
                }
                $user = User::where($where)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionId,
                    ]);
                }
                $token = Auth::guard('api')->login($user);
                break;
        }
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    //token登录

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function store($request)
    {
        $username = $request->username;
        filter_var($username, FILTER_VALIDATE_EMAIL) ? $credentials['email'] = $username : $credentials['phone'] = $username;
        $credentials['password'] = $request->password;
        if (!$token = auth('api')->attempt($credentials)) {
            throw new AuthenticationException('用户名或密码错误');
        }
        return $this->respondWithToken($token)->setStatusCode(201);
    }
    //获取code
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4a44ae1f8d2661bd&redirect_uri=http://larabbs.test&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
    public function getCode()
    {
//        $driver = Socialite::driver('weixin');
        $url['url'] = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . config('services.weixin.client_id') . '&redirect_uri=' . config('services.weixin.redirect') . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        return response()->json($url);
    }

}