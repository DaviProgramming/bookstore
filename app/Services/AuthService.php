<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function attemptLogin(array $credentials)
    {
        try {
            $token = JWTAuth::attempt($credentials);
            return $token;
        } catch (JWTException $e) {
            throw new JWTException('Erro ao tentar autenticar usuário.');
        }
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
        try {
            $newToken = JWTAuth::setToken($token)->refresh();
            return $newToken;
        } catch (JWTException $e) {
            throw new JWTException('Erro ao tentar atualizar o token.');
        }
    }
}
