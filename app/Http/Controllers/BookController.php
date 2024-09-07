<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
class BookController extends Controller
{
    public function index(){

        try {
            $token = session('jwt_token');
    
            $user = JWTAuth::setToken($token)->authenticate();


        } catch (JWTException $e) {
           
            return redirect()->route('pagina.login');

        }
        return view('pages.dashboard', ['user' => $user]);

    }

    public function create($page = null){


        try {

            $token = session('jwt_token');
    
            $user = JWTAuth::setToken($token)->authenticate();


        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            session()->forget('jwt_token');
           
            return redirect()->route('pagina.login');

        }

        return view('pages.dashboard')->with(['user' => $user, 'page' => $page]);


    }
}
