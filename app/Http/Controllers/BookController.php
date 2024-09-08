<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Book;
use Exception;

class BookController extends Controller
{
    public function index($page = null){

        try {

            $token = session('jwt_token');
    
            $user = JWTAuth::setToken($token)->authenticate();
            $all_books = Book::all();

        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            session()->forget('jwt_token');
           
            return redirect()->route('pagina.login');

        }

        return view('pages.dashboard')->with(['user' => $user, 'page' => $page, 'books' => $all_books]);

    }

    public function showEditForm($id){

        try {

            $token = session('jwt_token');
    
            $user = JWTAuth::setToken($token)->authenticate();

        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            session()->forget('jwt_token');
           
            return redirect()->route('pagina.login');

        }

        $book = Book::find($id);


        if($book){

         return view('pages.dashboard')->with(['page' => 'editar', 'book' => $book, 'user' => $user]);

        }else{

            return redirect()->route('pagina.dashboard', ['page' => 'inicio']);

        }




    }

    public function store(Request $request){


        $valida = Validator::make($request->all(), [
            'titulo' => 'required|string|min:3', // verifica se é uma string e tem no minimo 3 caracteres
            'descricao' => 'required|string|min:10', // verifica se é uma string e tem no minimo 10 caracteres
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


        try{

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

        return response()->json(['status' => 'success', 'message' => 'Livro criado com sucesso', 'content' => $livro, 201]);

        }catch(Exception $e){


            return response()->json(['status' => 'error', 'message' => $e->getMessage() , 401]);


        }

        

    }

    public function delete(Request $request){

        $valida = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:books,id' , // verifica se n está vazio e se é um integer
        ]);
        

        if ($valida->fails()) {

            $erros = $valida->messages(); // captura o erro

            return response()->json(['status' => 'error' , 'message' => $erros], 404); // se a validacao falhar, retorno um erro

        }

        $book_id = $request->book_id;

        $book = Book::find($book_id);


        if($book){

            if (Storage::disk('public')->exists($book['image_path'])) {
                Storage::disk('public')->delete($book['image_path']);
            }

            $book->delete();


            return response()->json(['status' => 'success', 'message' => 'Livro excluido com sucesso', 201]);
            
        }else {

            return response()->json([
                'status' => 'error',
                'message' => 'Livro não encontrado!'
            ], 404);
        }





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
