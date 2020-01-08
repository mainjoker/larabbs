<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/8
 * Time: 10:11
 */

namespace App\Http\Service\Api;


use App\Http\Resources\ImagesResource;
use Illuminate\Support\Str;

class ImageService extends BaseService
{
    public function store($request, $uploader, $image)
    {
        $user = $request->user();
        $size = $request->type == 'avatar' ? 416 : 1024;
        $result = $uploader->save($request->image, Str::plural($request->type), $user->id, $size);
        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();
        return new ImagesResource($image);
    }

}