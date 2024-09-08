<?php

namespace App\Repositories;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Session;

class LoginRepository implements LoginRepositoryInterface
{
    public function attemptLogin(array $credentials)
    {
        return JWTAuth::attempt($credentials);
    }

    public function getTokenFromSession()
    {
        return session('jwt_token');
    }

    public function setTokenInSession(string $token)
    {
        session(['jwt_token' => $token]);
    }

    public function flushSession()
    {
        Session::flush();
    }

    public function refreshToken(string $token)
    {
        return JWTAuth::setToken($token)->refresh();
    }
}