<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class LoginController extends Controller
{
    public function index(){

        $page = 'login';

        return view('pages.login')->with(['page' => $page]);

    }

    public function login(Request $request){

        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5', // Senha deve ser uma string com pelo menos 8 caracteres
            'email' => 'required|email', // verifica se este é um email valido
        ]);

        if ($valida->fails()) {


            return response()->json(['status' => 'error' , 'message' => 'dados invalídos'], 404); // se a validacao falhar, retorno um erro

        }

        $credentials = $request->only('email', 'password');

        try {

            // Tento criar o token utilizando o jwtAuth
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos'], 401); 
            }
            
            // Armazenando o token JWT na sessão

            if (!Session::isStarted()) {
                Session::start();
            }

            session(['jwt_token' => $token]);
        
            return response()->json(['status' => 'success', 'message' => 'Login realizado com sucesso!', 201]);
            
        } catch (JWTException $e) {

            // Se ocorrer algum outro erro, retorno este erro para que o usuário possa tentar realizar o login novamente
            return response()->json(['status' => 'error', 'message' => 'Algum erro acabou ocorrendo, tente novamente.'], 500);
        }


        return response()->json(['status' => 'error', 'message' => 'passou por todo mundo'], 401);




    }

    public function logout(Request $request){


    }


    public function refresh(Request $request){

        try {
            // Obtém o token da sessão
            $token = session('jwt_token');

            // Verifica e gera um novo token
            $newToken = JWTAuth::setToken($token)->refresh();

            // Atualiza o token na sessão
            session(['jwt_token' => $newToken]);

            

        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Não foi possível atualizar o token.'], 401);

        }
    }


}
