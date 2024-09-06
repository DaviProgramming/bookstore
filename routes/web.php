<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'login'])->name('pagina.login');
Route::get('/cadastro', [PageController::class, 'cadastro'])->name('pagina.cadastro');
