<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

use App\Http\Middleware\VerificaLogado;
use App\Http\Middleware\VerificaNaoLogado;

// Rotas das páginas
Route::get('/', [LoginController::class, 'index'])->middleware(VerificaNaoLogado::class)->name('pagina.login'); // Página de login
Route::get('/cadastro', [UserController::class, 'create'])->middleware(VerificaNaoLogado::class)->name('pagina.cadastro'); // Página de cadastro de usuário
Route::get('/dashboard/{page?}', [BookController::class, 'index'])->middleware(VerificaLogado::class)->name('pagina.dashboard'); // Página do dashboard 
Route::get('/dashboard/editar/{id}', [BookController::class, 'showEditForm'])->middleware(VerificaLogado::class)->name('pagina.edit-livro'); // Página para editar um livro específico

// Rotas de autenticação
Route::post('/auth/cadastro', [UserController::class, 'store'])->middleware(VerificaNaoLogado::class)->name('evento.cria-usuario'); // Rota para criar um novo usuário
Route::post('/auth/login', [LoginController::class, 'login'])->middleware(VerificaNaoLogado::class)->name('evento.login'); // Rota para login do usuário
Route::post('/auth/logout', [LoginController::class, 'logout'])->middleware(VerificaLogado::class)->name('auth.logout'); // Rota para logout do usuário

// Rotas de ações dos livros
Route::post('/book/novo-livro', [BookController::class, 'store'])->middleware(VerificaLogado::class)->name('book.novo-livro'); // Rota para adicionar um novo livro
Route::put('/book/editar-livro', [BookController::class, 'edit'])->middleware(VerificaLogado::class)->name('book.editar-livro'); // Rota para editar um livro existente
Route::delete('/book/delete-livro', [BookController::class, 'delete'])->middleware(VerificaLogado::class)->name('book.delete-livro'); // Rota para deletar um livro
Route::post('/book/favoritar', [BookController::class, 'favorite'])->middleware(VerificaLogado::class)->name('book.favorita-livro');// Rota para favoritar um livro




