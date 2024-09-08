<?php

namespace App\Repositories\Api;

interface ApiAuthRepositoryInterface
{
    public function attemptLogin(array $credentials);
    public function registerUser(array $data);
    public function setTokenInSession($token);
    public function getTokenFromSession();
    public function refreshToken($token);
    public function flushSession();
}