<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class VerificaLogado
{
    
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {

            // Redireciona para a rota 'Login' se o usuário estiver autenticado
            return redirect()->route('/'); 
        }
        return $next($request);
    }
}
