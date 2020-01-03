<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Service\Api\UserService;

class UserController extends BaseController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function store(UserRequest $request)
    {
       return $this->service->store($request);
    }
}
