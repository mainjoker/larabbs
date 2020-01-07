<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Service\Api\AuthorizationService;

class AuthorizationsController extends BaseController
{
    public function __construct(AuthorizationService $service)
    {
        $this->service=$service;
    }

    /**
     * @param SocialAuthorizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function SocialStore(SocialAuthorizationRequest $request)
    {
        return $this->service->SocialStore($request);
    }

    public function getCode()
    {
        return $this->service->getCode();
    }

    /**
     * @param AuthorizationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function store(AuthorizationRequest $request)
    {
        return $this->service->store($request);
    }
}
