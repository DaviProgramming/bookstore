<?php

namespace App\Repositories;

interface LoginRepositoryInterface
{
    public function attemptLogin(array $credentials);
    public function getTokenFromSession();
    public function setTokenInSession(string $token);
    public function flushSession();
    public function refreshToken(string $token);
}