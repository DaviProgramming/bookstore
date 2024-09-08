<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Api\ApiBookService;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(ApiBookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(Request $request)
    {

        try {

            $valida = Validator::make($request->all(), [
                'titulo' => 'required|string|min:3',
                'descricao' => 'required|string|min:10',
                'imagem' => 'required|mimes:jpg,jpeg,png|max:3072',
            ]);

            if ($valida->fails()) {
                $erros = $valida->messages();
                return response()->json(['status' => 'error', 'message' => $erros], 404);
            }

            $token = $request->bearerToken();



            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
            }

            try {

                Log::info('Token no controller: ' . $token);

                $livro = $this->bookService->createBook($request->all(), $token);

                return response()->json(['status' => 'success', 'message' => 'Livro criado com sucesso', 'content' => $livro], 201);
            } catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
            }
        } catch (Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Token expirado ou invalido.'], 500);
        }
    }

    public function edit(Request $request)
    {

        try {

            $valida = Validator::make($request->all(), [
                'titulo' => 'required|string|min:3',
                'descricao' => 'required|string|min:10',
                'imagem' => 'nullable|mimes:jpg,jpeg,png|max:3072',
                'book_id' => 'required|integer|exists:books,id',
            ]);

            if ($valida->fails()) {
                $erros = $valida->messages();
                return response()->json(['status' => 'error', 'message' => $erros], 404);
            }

            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
            }

            try {
                $this->bookService->updateBook($request->all(), $token);

                return response()->json(['status' => 'success', 'message' => 'Livro atualizado com sucesso!', 'token' => $token]);
            } catch (Exception $e) {

                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
            }
        } catch (Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Token expirado ou invalido.'], 500);
        }
    }

    public function favorite(Request $request)
    {

        try {

            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
            }

            $user = JWTAuth::setToken($token)->authenticate();
            $book_id = $request->input('book_id');

            try {
                $this->bookService->favoriteBook($user->id, $book_id);
                return response()->json(['status' => 'success', 'message' => 'Livro favoritado com sucesso!']);
            } catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
            }
        } catch (JWTException $e) {

            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);
        }
    }

    public function unfavorite(Request $request)
    {

        try {

            $token = $request->bearerToken();
            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
            }

            $user = JWTAuth::setToken($token)->authenticate();
            $book_id = $request->book_id;

            try {
                $this->bookService->unfavoriteBook($user->id, $book_id);
                return response()->json(['status' => 'success', 'message' => 'Livro removido com sucesso!']);
            } catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
            }
        } catch (Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);
        }
    }

    public function delete(Request $request)
    {

        try {

            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
            }

            $valida = Validator::make($request->all(), [
                'book_id' => 'required|integer|exists:books,id',
            ]);

            if ($valida->fails()) {
                $erros = $valida->messages();
                return response()->json(['status' => 'error', 'message' => $erros], 404);
            }

            try {

                $this->bookService->deleteBook($request->input('book_id'));

                return response()->json(['status' => 'success', 'message' => 'Livro deletado com sucesso!']);
            } catch (Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
            }
        } catch (JWTException $e) {

            return response()->json(['status' => 'error', 'message' => 'Token expirado.'], 500);
        }
    }
}
