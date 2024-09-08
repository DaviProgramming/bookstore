<?php

namespace App\Services;

interface BookServiceInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function favoritedBooks($userId);
    public function favoriteBook($userId, $bookId);
    public function unfavoriteBook($userId, $bookId);
}