<?php

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthHelper
{
    public static function isAuthenticated()
    {
        return JWTAuth::parseToken()->authenticate() !== null;
    }
}