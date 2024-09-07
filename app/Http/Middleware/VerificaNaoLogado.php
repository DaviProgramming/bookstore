<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;


class VerificaNaoLogado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try{

            $token = session('jwt_token');

            if($token != null && JWTAuth::setToken($token)->checkOrFail()){
                return redirect()->route('pagina.dashboard');
            }

            return $next($request);

           
        }catch(JWTException $e){

            Log::error('JWTException: ' . $e->getMessage());
            

        }

       


        return $next($request);
    }
}
