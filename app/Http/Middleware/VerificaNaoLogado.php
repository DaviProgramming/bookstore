<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
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

            if($token != null){
                return redirect()->route('pagina.dashboard');
            }

            return $next($request);

           
        }catch(JWTException $e){

            

        }

       


        return $next($request);
    }
}
