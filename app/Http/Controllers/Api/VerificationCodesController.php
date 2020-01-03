<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodesRequest;
use App\Http\Service\Api\VerificationService;

class VerificationCodesController extends BaseController
{
    public function __construct(VerificationService $service)
    {
        $this->service = $service;
    }
    public function store(VerificationCodesRequest $request)
    {
        return $this->service->store($request);
    }
}
