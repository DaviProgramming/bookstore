<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Book;
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

    public function store(Request $request){


        $valida = Validator::make($request->all(), [
            'titulo' => 'required|string|min:3', // Senha deve ser uma string com pelo menos 8 caracteres
            'descricao' => 'required|string|min:30', // verifica se este é um email valido
            'imagem' => 'required|mimes:jpg,jpeg,png|max:3072', // Aceita apenas PNG, JPG, JPEG com limite de 3 MB
        ]);

        if ($valida->fails()) {


            $erros = $valida->messages(); // captura o erro

            return response()->json(['status' => 'error' , 'message' => $erros], 404); // se a validacao falhar, retorno um erro

        }

        $titulo = $request->titulo;
        $descricao = $request->descricao;
        $imagem = $request->file('imagem');

        $this->ensureDirectoriesExist();

        $pathImagem = $imagem->store('thumbnail', 'public');

        $token = session('jwt_token');
    
        $user = JWTAuth::setToken($token)->authenticate();

        $livro = new Book([
            'title' => $titulo,
            'description' => $descricao,
            'image_path' => $pathImagem,
        ]);

        $livro->creator()->associate($user);

        $livro->save();

        return response()->json(['status' => 'success', 'message' => 'chegou no servidor!', 'content' => $livro, 201]);

    }


    protected function ensureDirectoriesExist() // funcao que garante que os diretorios existam 
    {
        $directories = [
            'public/thumbnail',
        ];

        foreach ($directories as $directory) {

            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
        }
    }
}
