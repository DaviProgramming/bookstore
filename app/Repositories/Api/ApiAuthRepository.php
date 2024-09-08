<?php

namespace App\Repositories\Api;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class ApiAuthRepository implements ApiAuthRepositoryInterface
{
    public function attemptLogin(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return null;
            }
            return $token;
        } catch (JWTException $e) {
            throw new JWTException('Não foi possível criar o token.');
        }
    }

    public function registerUser(array $data)
    {      
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function setTokenInSession($token)
    {
        session()->put('api_token', $token);
    }

    public function getTokenFromSession()
    {
        return session()->get('api_token');
    }

    public function refreshToken($token)
    {
        try {
            return JWTAuth::setToken($token)->refresh();
        } catch (JWTException $e) {
            throw new JWTException('Não foi possível atualizar o token.');
        }
    }

    public function flushSession()
    {
        session()->forget('api_token');
    }
}
