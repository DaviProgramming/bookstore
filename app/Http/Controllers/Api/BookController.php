<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Models\Book;
use Exception;

class BookController extends Controller
{
    public function store(Request $request)
    {

        $valida = Validator::make($request->all(), [
            'titulo' => 'required|string|min:3', // verifica se é uma string e tem no minimo 3 caracteres
            'descricao' => 'required|string|min:10', // verifica se é uma string e tem no minimo 10 caracteres
            'imagem' => 'required|mimes:jpg,jpeg,png|max:3072', // Aceita apenas PNG, JPG, JPEG com limite de 3 MB
        ]);

        if ($valida->fails()) {

            $erros = $valida->messages(); // captura o erro

            return response()->json(['status' => 'error', 'message' => $erros], 404); // se a validacao falhar, retorno um erro

        }

        $titulo = $request->titulo;
        $descricao = $request->descricao;
        $imagem = $request->file('imagem');

        $this->ensureDirectoriesExist();

        try {

            $pathImagem = $imagem->store('thumbnail', 'public');

            $token = $request->bearerToken();

            $user = JWTAuth::setToken($token)->authenticate();

            $livro = new Book([
                'title' => $titulo,
                'description' => $descricao,
                'image_path' => $pathImagem,
            ]);

            $livro->creator()->associate($user);

            $livro->save();

            return response()->json(['status' => 'success', 'message' => 'Livro criado com sucesso', 'content' => $livro, 201]);
        } catch (Exception $e) {


            return response()->json(['status' => 'error', 'message' => $e->getMessage(), 401]);
        }
    }

    public function edit(Request $request)
    {


        $valida = Validator::make($request->all(), [
            'titulo' => 'required|string|min:3', // verifica se é uma string e tem no minimo 3 caracteres
            'descricao' => 'required|string|min:10', // verifica se é uma string e tem no minimo 10 caracteres
            'imagem' => 'nullable|mimes:jpg,jpeg,png|max:3072', // Aceita apenas PNG, JPG, JPEG com limite de 3 MB
            'book_id' => 'required|integer|exists:books,id', // Verifica se n está vazio e se é um integer
        ]);

        if ($valida->fails()) {

            $erros = $valida->messages(); // captura o erro

            return response()->json(['status' => 'error', 'message' => $erros], 404); // se a validacao falhar, retorno um erro

        }

        $titulo = $request->titulo;
        $descricao = $request->descricao;
        $imagem = $request->file('imagem');
        $book_id = $request->book_id;

        $book = Book::find($book_id);

        

        if($book){

            try{

                $book->title = $titulo;
                $book->description = $descricao;
    
                if ($imagem) {
    
                    // Remove a imagem antiga, se existir
                    if (Storage::disk('public')->exists($book->image_path)) {
                        Storage::disk('public')->delete($book->image_path);
                    }
        
                    // Armazena a nova imagem e atualiza o path
                    $pathImagem = $imagem->store('thumbnail', 'public');
                    $book->image_path = $pathImagem;
                }
    
                $book->save();
    
                return response()->json(['status' => 'success', 'message' => 'Livro atualizado com sucesso!']);

                
            }catch(Exception $e){

                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);


            }

        }

        

         return response()->json(['status' => 'error', 'message' => 'Livro não encontrado'], 404);
    }

    public function favorite(Request $request){

        $token = $request->bearerToken();
        $user = JWTAuth::setToken($token)->authenticate();

        $book_id = $request->input('book_id'); 

        // Verifica se o livro  existe
        $book = Book::find($book_id);
        
        // Verifica se o livro e o usuarío existe

        if (!$book || !$user) {
            return response()->json(['status' => 'error', 'message' => 'Livro não encontrado'], 404);
        }
    
        // Verifica se o livro já foi favoritado pelo usuário
        if ($user->favoritedBooks()->where('book_id', $book_id)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Você já favoritou este livro'], 400);
        }
    
        // Adiciona o livro aos favoritos do usuário
        $user->favoritedBooks()->attach($book_id);
    
        return response()->json(['status' => 'success', 'message' => 'Livro favoritado com sucesso!']);

    }

    public function unfavorite(Request $request){

        $token = $request->bearerToken();
        $user = JWTAuth::setToken($token)->authenticate();
        $book_id = $request->book_id;

        $book = Book::find($book_id);

        if (!$book || !$user) {
            return response()->json(['status' => 'error', 'message' => 'Livro não encontrado'], 404);
        }

        
        if ($user->favoritedBooks->contains($book->id)) {
                $user->favoritedBooks()->detach($book->id); // Remove o livro dos favoritos
        }

        return response()->json(['status' => 'success', 'message' => 'Livro removido com sucesso!']);


    }

    public function delete(Request $request)
    {

        $valida = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:books,id', // verifica se n está vazio e se é um integer
        ]);


        if ($valida->fails()) {

            $erros = $valida->messages(); // captura o erro

            return response()->json(['status' => 'error', 'message' => $erros], 404); // se a validacao falhar, retorno um erro

        }

        $book_id = $request->book_id;

        $book = Book::find($book_id);


        if ($book) {

            if (Storage::disk('public')->exists($book['image_path'])) {
                Storage::disk('public')->delete($book['image_path']);
            }

            $book->delete();


            return response()->json(['status' => 'success', 'message' => 'Livro excluido com sucesso', 201]);
        } else {

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
