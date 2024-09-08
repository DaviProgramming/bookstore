<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BookRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LivroCriadoComSucesso;
 
use Exception;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function createBook($data)
    {
        // Validação dos dados
        $validator = Validator::make($data, [
            'titulo' => 'required|string|min:3',
            'descricao' => 'required|string|min:10',
            'imagem' => 'required|mimes:jpg,jpeg,png|max:3072',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'message' => $validator->messages(), 'code' => 404];
        }

        $imagem = $data['imagem'];

        try {
            // Armazena a imagem e obtém o path
            $pathImagem = $imagem->store('thumbnail', 'public');

            // Obtém o usuário autenticado
            $token = session('jwt_token');
            $user = JWTAuth::setToken($token)->authenticate();

            // Cria o livro
            $livro = $this->bookRepository->create([
                'title' => $data['titulo'],
                'description' => $data['descricao'],
                'image_path' => $pathImagem,
                'creator_id' => $user->id,
            ]);

            return ['status' => 'success', 'message' => 'Livro criado com sucesso', 'content' => $livro, 'code' => 201];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 401];
        }
    }

    public function updateBook($data, $bookId)
    {
        // Validação dos dados
        $validator = Validator::make($data, [
            'titulo' => 'required|string|min:3',
            'descricao' => 'required|string|min:10',
            'imagem' => 'nullable|mimes:jpg,jpeg,png|max:3072',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'message' => $validator->messages(), 'code' => 404];
        }

        $book = $this->bookRepository->find($bookId);

        if (!$book) {
            return ['status' => 'error', 'message' => 'Livro não encontrado', 'code' => 404];
        }

        try {
            // Atualiza o livro com os dados fornecidos
            $book->title = $data['titulo'];
            $book->description = $data['descricao'];

            if (isset($data['imagem'])) {
                $imagem = $data['imagem'];

                // Remove a imagem antiga, se existir
                if (Storage::disk('public')->exists($book->image_path)) {
                    Storage::disk('public')->delete($book->image_path);
                }

                // Armazena a nova imagem e atualiza o path
                $pathImagem = $imagem->store('thumbnail', 'public');
                $book->image_path = $pathImagem;
            }

            $book->save();

            return ['status' => 'success', 'message' => 'Livro atualizado com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 404];
        }
    }

    public function favoriteBook($token, $bookId)
    {
        // Autentica o usuário com o token JWT
        $user = JWTAuth::setToken($token)->authenticate();

        // Encontra o livro
        $book = $this->bookRepository->find($bookId);

        if (!$book || !$user) {
            return ['status' => 'error', 'message' => 'Livro não encontrado', 'code' => 404];
        }

        // Verifica se o livro já foi favoritado pelo usuário
        if ($user->favoritedBooks()->where('book_id', $bookId)->exists()) {
            return ['status' => 'error', 'message' => 'Você já favoritou este livro', 'code' => 400];
        }

        try {
            // Adiciona o livro aos favoritos do usuário
            $user->favoritedBooks()->attach($bookId);
            return ['status' => 'success', 'message' => 'Livro favoritado com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 400];
        }
    }

    public function unfavoriteBook($token, $bookId)
    {
        // Autentica o usuário com o token JWT
        $user = JWTAuth::setToken($token)->authenticate();

        // Encontra o livro
        $book = $this->bookRepository->find($bookId);

        if (!$book || !$user) {
            return ['status' => 'error', 'message' => 'Livro não encontrado', 'code' => 404];
        }

        try {
            // Desfavorita o livro
            $this->bookRepository->unfavoriteBook($user->id, $bookId);
            return ['status' => 'success', 'message' => 'Livro desfavoritado com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage(), 'code' => 400];
        }
            
    }

    public function deleteBook($bookId){
        
        // Valida o ID do livro
        $validator = Validator::make(['book_id' => $bookId], [
            'book_id' => 'required|integer|exists:books,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages();
            return ['status' => 'error', 'message' => $errors, 'code' => 404];
        }

        // Encontra o livro
        $book = $this->bookRepository->find($bookId);

        if ($book) {
            // Remove a imagem associada, se existir
            if (Storage::disk('public')->exists($book->image_path)) {
                Storage::disk('public')->delete($book->image_path);
            }

            // Deleta o livro
            $this->bookRepository->delete($bookId);

            return ['status' => 'success', 'message' => 'Livro excluído com sucesso!', 'code' => 201];
        }

        return ['status' => 'error', 'message' => 'Livro não encontrado!', 'code' => 404];
    }

    public function enviarEmail($token, $titulo){

        try {
            
            // Autentica o usuário pelo token JWT
            $user = JWTAuth::setToken($token)->authenticate();
            
            // Envia o e-mail de confirmação para o usuário
            Mail::to($user->email)->send(new LivroCriadoComSucesso($user->name, $titulo));
        } catch (Exception $e) {
            throw new Exception('Erro ao enviar o e-mail: ' . $e->getMessage());
        }

    }
}
