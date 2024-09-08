<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BookRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


use Exception;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
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
}
