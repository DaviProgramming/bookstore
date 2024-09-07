<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

Route::get('/', [PageController::class, 'login'])->name('pagina.login');
Route::get('/cadastro', [UserController::class, 'create'])->name('pagina.cadastro');


Route::post('/evento/cadastro', [UserController::class, 'store'])->name('evento.cria-usuario');
