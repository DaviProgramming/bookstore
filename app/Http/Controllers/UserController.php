<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class UserController extends Controller
{
    public function create(){

        $page = 'cadastro';

        return view('pages.cadastro')->with(['page' => $page]);

    }

    public function store(Request $request){

        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5', // Senha deve ser uma string com pelo menos 8 caracteres
            'name' => 'required|string', // Nome deve ser uma string não vazia
            'email' => 'required|email', // verifica se este é um email valido
        ]);

        if ($valida->fails()) {

            // se o verificador falha, retorno o erro

            return response()->json(['status' => 'error' , 'message' => 'dados invalídos'], 404); // se a validacao falhar, retorno um erro

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

                session(['jwt_token' => $token]);

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
}
