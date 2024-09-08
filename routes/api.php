<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookController;
// rotas de Auth

Route::post('/login', [AuthController::class, 'login']);
Route::post('/cadastro', [AuthController::class, 'store']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

//rotas dos livros

Route::post('/book/criar-livro', [BookController::class, 'store']);
Route::post('/book/editar-livro', [BookController::class, 'edit']);
Route::post('/book/deletar-livro', [BookController::class, 'delete']);
Route::post('/book/favoritar-livro', [BookController::class, 'favorite']);
Route::post('/book/desfavoritar-livro', [BookController::class, 'unfavorite']);

