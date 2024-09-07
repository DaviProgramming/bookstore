<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class VerificaLogado
{
    
    public function handle(Request $request, Closure $next)
    {

        try {
           
            $token = session('jwt_token');

            JWTAuth::setToken($token)->checkOrFail();

            return $next($request);
            
        }catch(TokenExpiredException $e){

            try {

                $newToken = JWTAuth::refresh(JWTAuth::getToken());
                
                JWTAuth::setToken($newToken)->toUser();
                
                session(['jwt_token' => $newToken]);

                return $next($request);
                
            } catch (JWTException $refreshException) {
                // Se não for possível fazer o refresh do token, redireciona para o login
                Log::error('Erro ao tentar fazer o refresh do token: ' . $refreshException->getMessage());
                return redirect()->route('pagina.login');
            }

        }catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            return redirect()->route('pagina.login');

        }

    }


    }

