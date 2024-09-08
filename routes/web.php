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

use App\Http\Middleware\RefreshToken;

Route::get('/', [LoginController::class, 'index'])->middleware(VerificaNaoLogado::class)->name('pagina.login');
Route::get('/cadastro', [UserController::class, 'create'])->middleware(VerificaNaoLogado::class)->name('pagina.cadastro');
Route::get('/dashboard/{page?}', [BookController::class, 'index'])->middleware(VerificaLogado::class)->name('pagina.dashboard');

Route::post('/evento/cadastro', [UserController::class, 'store'])->middleware(VerificaNaoLogado::class)->name('evento.cria-usuario');
Route::post('/evento/login', [LoginController::class, 'login'])->middleware(VerificaNaoLogado::class)->name('evento.login');

Route::post('/book/novo-livro', [BookController::class, 'store'])->middleware(VerificaLogado::class)->name('book.novo-livro');
Route::delete('/book/delete-livro', [BookController::class, 'delete'])->middleware(VerificaLogado::class)->name('book.delete-livro');

Route::get('/evento/forget', function () {

    Session::flush();

    return redirect()->route('pagina.login');
})->name('sair-teste');

Route::post('/logout', function (Request $request) {
    
    $request->session()->flush();

    return response()->json([
        'status' => 'success',
        'message' => 'Sessão apagada com sucesso.',
    ]);
})->name('session.destroy');