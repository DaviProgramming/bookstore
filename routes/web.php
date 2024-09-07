<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

use App\Http\Middleware\VerificaLogado;
use App\Http\Middleware\VerificaNaoLogado;

Route::get('/', [LoginController::class, 'index'])->middleware(VerificaNaoLogado::class)->name('pagina.login');
Route::get('/cadastro', [UserController::class, 'create'])->middleware(VerificaNaoLogado::class)->name('pagina.cadastro');
Route::get('/dashboard', [BookController::class, 'index'])->middleware(VerificaLogado::class)->name('pagina.dashboard');

Route::post('/evento/cadastro', [UserController::class, 'store'])->middleware(VerificaNaoLogado::class)->name('evento.cria-usuario');
Route::post('/evento/login', [LoginController::class, 'login'])->middleware(VerificaNaoLogado::class)->name('evento.login');

