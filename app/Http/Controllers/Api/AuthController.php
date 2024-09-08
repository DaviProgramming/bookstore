<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request){

        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:5', // Senha deve ser uma string com pelo menos 5 caracteres
            'email' => 'required|email', // Verifica se o email é válido
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422); // Código de status 422 para erro de validação
        }

        $credentials = $request->only('email', 'password');

        try {
            // Tenta criar o token usando JWTAuth
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'E-mail ou senha incorretos'
                ], 401); // Código de status 401 para não autorizado
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Login realizado com sucesso!',
                'token' => $token
            ], 200); // Código de status 200 para sucesso
            
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao gerar o token, tente novamente.'
            ], 500); // Código de status 500 para erro interno do servidor
        }

    }

    public function store(Request $request){

        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5', // Senha deve ser uma string com pelo menos 8 caracteres
            'name' => 'required|string', // Nome deve ser uma string não vazia
            'email' => 'required|email', // verifica se este é um email valido
        ]);

        if ($valida->fails()) {

            // se o verificador falha, retorno o erro

            return response()->json(['status' => 'error' , 'message' => $valida->errors()], 404); // se a validacao falhar, retorno um erro

        }

        $email = $request->email;
        $name = $request->name;
        $password = $request->password;

        //verifico se já existe um usuário com este email
        
        $usuarioExistente = User::where('email', $email)->first();

        if($usuarioExistente){

            return response()->json([
                'message' => 'O email já está em uso',
                'status' => 'error'
            ], 404);

        }

        //após a verificação eu crio o novo usuário

        $user = User::create(['email' => $request->email, 'name' => $name, 'password' => hash::make($password)]);

        if ($user) {
            // Gera um token JWT para o usuário recém-criado
            $token = JWTAuth::attempt($request->only('email', 'password'));
    
            if ($token) {


                return response()->json([
                    'status' => 'success',
                    'message' => 'Usuário criado!',
                    'token' => $token // Retorna o token JWT
                ], 201); // Código de status 201 para recurso criado

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuário criado, mas falha ao gerar o token. Tente novamente.'
                ], 500); // Código de status 500 para erro interno do servidor
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível criar o usuário'
            ], 500); // Código de status 500 para erro interno do servidor
        }


    }

    public function refreshToken(Request $request){

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
        }

        try {

            $token = $request->bearerToken();
            JWTAuth::setToken($token);
            $newToken = JWTAuth::refresh($token);

            
            JWTAuth::setToken($newToken)->toUser();


            return response()->json([
                'status' => 'success',
                'message' => 'Token gerado com sucesso!',
                'token' => $token
            ], 200); // Código de status 200 para sucesso
            

            
        } catch (JWTException $refreshException) {

            // Se não for possível fazer o refresh do token

            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao gerar o token, tente novamente.'
            ], 500); // Código de status 500 para erro interno do servidor
        }
    }
}
