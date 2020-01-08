<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Request;
use App\Http\Resources\UserResource;
use App\Http\Service\Api\UserService;
use App\Models\User;

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

    public function show(User $user,\Illuminate\Http\Request $request)
    {
        return (new UserResource($user))->showSensitiveFields();
    }

    public function me(\Illuminate\Http\Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }

    public function update(UserRequest $request)
    {
        return $this->service->update($request);
    }
}
