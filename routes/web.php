<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\VerificaLogado;

Route::get('/', [PageController::class, 'login'])->middleware(VerificaLogado::class)->name('pagina.login');
Route::get('/cadastro', [UserController::class, 'create'])->middleware(VerificaLogado::class)->name('pagina.cadastro');


Route::post('/evento/cadastro', [UserController::class, 'store'])->middleware(VerificaLogado::class)->name('evento.cria-usuario');
