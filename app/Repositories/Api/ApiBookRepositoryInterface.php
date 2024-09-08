<?php

namespace App\Repositories\Api;

use App\Models\Book;
use Illuminate\Support\Collection;

interface ApiBookRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?Book;
    public function create(array $data): Book;
    public function update($id, array $data): ?Book;
    public function delete($id): bool;
    public function favoritedBooks($userId): Collection;
    public function favoriteBook($userId, $bookId): bool;
    public function unfavoriteBook($userId, $bookId): bool;
}