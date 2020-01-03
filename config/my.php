<?php
return [
    'sms' => [
        'sign_name' => env('SIGN_NAME',null),
        'template' => env('TEMPLATE',null),
        'ali_access_key_id' => env('ALI_ACCESS_KEY_ID',null),
        'ali_access_key_secret' => env('ALI_ACCESS_KEY_SECRET',null)
    ],
    /*
   * 接口频率限制
   */
    'rate_limits' => [
        // 访问频率限制，次数/分钟
        'access' => env('RATE_LIMITS', '60,1'),
        // 登录相关，次数/分钟
        'sign' => env('SIGN_RATE_LIMITS', '10,1'),
    ],
];