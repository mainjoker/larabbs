<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use App\Http\Service\Api\CaptchaService;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends BaseController
{
    public function __construct(CaptchaService $service)
    {
        $this->service=$service;
    }

    public function store(CaptchaRequest $request,CaptchaBuilder $builder)
    {
        return $this->service->store($request,$builder);
    }
}
