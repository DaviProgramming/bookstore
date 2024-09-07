<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function create(){

        return view('pages.cadastro');

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

            return response()->json([
                'message' => 'Usuário criado com sucesso.',
                'status' => 'success'
            ], 201); 
        }else{

            return response()->json([
                'message' => 'Não foi possivel criar o usuário',
                'status' => 'error'
            ], 404);

        } 


        

    }
}
