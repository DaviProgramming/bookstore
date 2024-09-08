<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Models\Book;
use App\Models\User;

class BookRepository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $book = $this->model->find($id);
        if ($book) {
            $book->update($data);
        }
        return $book;
    }

    public function delete($id)
    {
        $book = $this->model->find($id);
        if ($book) {
            $book->delete();
        }
        return $book;
    }

    public function favoritedBooks($userId): Collection
    {
        return Book::whereHas('favoritedBy', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function favoriteBook($userId, $bookId)
    {
        $user = User::find($userId);
        $book = $this->model->find($bookId);

        if (!$book || !$user) {
            throw new \Exception('Livro ou usuário não encontrado');
        }

        if ($user->favoritedBooks()->where('book_id', $bookId)->exists()) {
            throw new \Exception('Você já favoritou este livro');
        }

        $user->favoritedBooks()->attach($bookId);
    }

    public function unfavoriteBook($userId, $bookId)
    {
        $user = User::find($userId);
        $book = $this->model->find($bookId);

        if (!$book || !$user) {
            throw new \Exception('Livro ou usuário não encontrado');
        }

        if ($user->favoritedBooks()->where('book_id', $bookId)->exists()) {
            $user->favoritedBooks()->detach($bookId);
        }
    }
}
