<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Service\Api\AuthorizationService;
use Illuminate\Support\Facades\Auth;

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

    public function update()
    {
        $token=Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }
}
