<?php

namespace App\Repositories\Api;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class ApiBookRepository implements ApiBookRepositoryInterface
{
    public function all(): Collection
    {
        return Book::all();
    }

    public function find($id): ?Book
    {
        return Book::find($id);
    }

    public function create(array $data): Book
    {
        try {
            // Cria o livro com os dados fornecidos
            $book = new Book([
                'title' => $data['title'],
                'description' => $data['description'],
                'image_path' => $data['image_path'],
            ]);
            
            // Associa o livro ao usuário
            $book->creator()->associate($data['user']);
            $book->save();
            
            return $book;
            
        } catch (Exception $e) {
            throw new Exception('Erro ao criar livro: ' . $e->getMessage());
        }
    }

    public function update($id, array $data): ?Book
    {
        try {
            $book = Book::find($id);
            
            if ($book) {
                $book->title = $data['title'];
                $book->description = $data['description'];
                
                if (isset($data['image_path'])) {
                    if (Storage::disk('public')->exists($book->image_path)) {
                        Storage::disk('public')->delete($book->image_path);
                    }
                    $book->image_path = $data['image_path'];
                }
                
                $book->save();
            }
            
            return $book;
        } catch (Exception $e) {
            throw new Exception('Erro ao atualizar livro: ' . $e->getMessage());
        }
    }

    public function delete($id): bool
    {
        try {
            $book = Book::find($id);
            
            if ($book) {
                if (Storage::disk('public')->exists($book->image_path)) {
                    Storage::disk('public')->delete($book->image_path);
                }
                
                return $book->delete();
            }
            
            return false;
        } catch (Exception $e) {
            throw new Exception('Erro ao deletar livro: ' . $e->getMessage());
        }
    }

    public function favoritedBooks($userId): Collection
    {
        $user = User::find($userId);

        if ($user) {
            return $user->favoritedBooks;
        }

        return collect(); // Retorna uma coleção vazia se o usuário não for encontrado
    }

    public function favoriteBook($userId, $bookId): bool
    {
        try {
            
            $user = User::find($userId);
            
            if ($user) {

                if (!$user->favoritedBooks()->where('book_id', $bookId)->exists()) {
                    $user->favoritedBooks()->attach($bookId);
                    return true;
                }
                
                return false;
            }
            
            return false;
        } catch (Exception $e) {

            throw new Exception('Erro ao favoritar livro: ' . $e->getMessage());

        }catch(JWTException $e){

            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);
        }
    }

    public function unfavoriteBook($userId, $bookId): bool
    {
        try {
            $user = User::find($userId);
            
            if ($user) {
                if ($user->favoritedBooks()->where('book_id', $bookId)->exists()) {
                    $user->favoritedBooks()->detach($bookId);
                    return true;
                }
                
                return false;
            }
            
            return false;
        } catch (Exception $e) {
            throw new Exception('Erro ao desfavoritar livro: ' . $e->getMessage());
        }
    }
}
