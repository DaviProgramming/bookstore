<?php

namespace App\Services\Api;

use App\Repositories\Api\ApiBookRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiBookService
{
    protected $bookRepository;

    public function __construct(ApiBookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function createBook(array $data, $token)
    {
        try {
            // Verifica e autentica o usuário com o token

            
            $user = JWTAuth::setToken($token)->authenticate();
            Log::info('Usuario: ' . $user);
            

            if (!$user) {
                throw new Exception('Token inválido');
            }

            // Armazena a imagem e obtém o caminho
            $pathImagem = $data['imagem']->store('thumbnail', 'public');

            // Cria o livro e associa ao usuário
            Log::info('Token recebido no Service: ' . $token);
            Log::info('Usuario: ' . $user);

            return $this->bookRepository->create([
                'title' => $data['titulo'],
                'description' => $data['descricao'],
                'image_path' => $pathImagem,
                'user' => $user,
            ]);
            
        } catch (Exception $e) {
            throw new Exception('Erro ao criar livro: ' . $e->getMessage());
        }
    }

    public function updateBook(array $data, $token)
    {
        try {
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                throw new Exception('Token inválido');
            }

            $book = $this->bookRepository->find($data['book_id']);

            if (!$book) {
                throw new Exception('Livro não encontrado');
            }

            $updateData = [
                'title' => $data['titulo'],
                'description' => $data['descricao'],
            ];

            if (isset($data['imagem'])) {
                if (Storage::disk('public')->exists($book->image_path)) {
                    Storage::disk('public')->delete($book->image_path);
                }

                $pathImagem = $data['imagem']->store('thumbnail', 'public');
                $updateData['image_path'] = $pathImagem;
            }

            return $this->bookRepository->update($data['book_id'], $updateData);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function favoriteBook($userId, $bookId)
    {
        try {

            $book = $this->bookRepository->find($bookId);

            if (!$book) {
                throw new Exception('Livro não encontrado');
            }

            if ($this->bookRepository->favoriteBook($userId, $bookId)) {
                return true;
            } else {
                throw new Exception('Você já favoritou este livro');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }catch(JWTException $e){


            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);

        }
    }

    public function unfavoriteBook($userId, $bookId)
    {
        try {
            $book = $this->bookRepository->find($bookId);

            if (!$book) {
                throw new Exception('Livro não encontrado');
            }

            if ($this->bookRepository->unfavoriteBook($userId, $bookId)) {
                return true;
            } else {
                throw new Exception('Este livro não está entre os favoritos');
            }
            
        } catch (Exception $e) {

            throw new Exception($e->getMessage());

        } catch(JWTException $e){

            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);
        }
        
    }

    public function deleteBook($bookId)
    {
        try {
            if ($this->bookRepository->delete($bookId)) {
                return true;
            } else {
                throw new Exception('Livro não encontrado');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
