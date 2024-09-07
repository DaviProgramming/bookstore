<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
class RefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $token = session('jwt_token');

        if($token){

            try {

                $token = session('jwt_token');

                JWTAuth::setToken($token)->checkOrFail();
                
                if ($token && ! JWTAuth::setToken($token)->checkOrFail()) {
                    // Token expirou, tentar atualizar
                    $newToken = JWTAuth::setToken($token)->refresh();
                    session(['jwt_token' => $newToken]);
                }
    
                return $next($request);
    
            } catch (JWTException $e) {
                // Caso o token não possa ser atualizado, redirecione para a página de login
                return redirect()->route('pagina.login');

                Log::error('JWTException: ' . $e->getMessage());

            }


        }else{

            // Caso o token não exista, redireciona para a página de login

            return redirect()->route('pagina.login');


        }
        
    }
}
