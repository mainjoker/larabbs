<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ImagesRequest;
use App\Http\Service\Api\ImageService;
use App\Models\Images;

class ImagesController extends BaseController
{
    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    public function store(ImagesRequest $request, ImageUploadHandler $uploader, Images $image)
    {
       return $this->service->store($request, $uploader, $image);
    }
}
