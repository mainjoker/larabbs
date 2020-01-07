<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller ;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public $service;
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
