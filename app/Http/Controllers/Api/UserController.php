<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Service\Api\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class UserController extends BaseController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param UserRequest $request
     * @return \App\Http\Resources\UserResource
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function store(UserRequest $request)
    {
       return $this->service->store($request);
    }
}
