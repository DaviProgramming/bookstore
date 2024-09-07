<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerificaLogado
{
    
    public function handle(Request $request, Closure $next)
    {

        try {
           
            $token = session('jwt_token');

            JWTAuth::setToken($token)->checkOrFail();

            return $next($request);
            
        } catch (JWTException $e) {

            return redirect()->route('pagina.login');

        }


    }


    }

