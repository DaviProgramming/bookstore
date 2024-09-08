<?php

namespace App\Services;

use App\Repositories\BookRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Book;
use App\Models\User;

class BookService implements BookServiceInterface
{
    protected $repository;

    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function favoritedBooks($userId): Collection
    {
        return $this->repository->favoritedBooks($userId);
    }

    public function favoriteBook($userId, $bookId)
    {

        $user = User::find($userId);
        $book = Book::find($bookId);

        if (!$book || !$user) {
            throw new \Exception('Livro ou usuário não encontrado');
        }

        if ($user->favoritedBooks()->where('book_id', $bookId)->exists()) {
            throw new \Exception('Você já favoritou este livro');
        }

        $user->favoritedBooks()->attach($bookId);

        return $user->favoritedBooks;
    }

    public function unfavoriteBook($userId, $bookId)
    {

        $user = User::find($userId);
        $book = Book::find($bookId);

        if (!$book || !$user) {
            throw new \Exception('Livro ou usuário não encontrado');
        }

        if ($user->favoritedBooks->contains($book->id)) {
            $user->favoritedBooks()->detach($book->id);
        }

        return $user->favoritedBooks;
    }
}