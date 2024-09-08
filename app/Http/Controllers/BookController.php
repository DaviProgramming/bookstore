<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use App\Services\BookService;
use Exception;

class BookController extends Controller
{

    protected $bookRepository;
    protected $bookService;

    public function __construct(BookRepositoryInterface $bookRepository, BookService $bookService)
    {
        $this->bookService = $bookService;
        $this->bookRepository = $bookRepository;
    }

    public function index($page = null)
    {

        try {

            $token = session('jwt_token');

            $user = JWTAuth::setToken($token)->authenticate();
            $all_books = Book::all();
            $favorited_books = $user->favoritedBooks->pluck('id');


        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            session()->forget('jwt_token');

            return redirect()->route('pagina.login');
        }

        return view('pages.dashboard')->with(['user' => $user, 'page' => $page, 'books' => $all_books, 'favorited_books' => $favorited_books]);
    }

    public function showEditForm($id)
    {

        try {

            $token = session('jwt_token');

            $user = JWTAuth::setToken($token)->authenticate();
        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());

            session()->forget('jwt_token');

            return redirect()->route('pagina.login');
        }

        $book = $this->bookRepository->find($id);


        if ($book) {

            return view('pages.dashboard')->with(['page' => 'editar', 'book' => $book, 'user' => $user]);
        } else {

            return redirect()->route('pagina.dashboard', ['page' => 'inicio']);
        }
    }

    public function store(Request $request)
    {


         // Prepara os dados para o serviço
         $data = $request->only(['titulo', 'descricao', 'imagem']);

         try {
             // Usa o serviço para criar o livro
             $result = $this->bookService->createBook($data);
 
             return response()->json($result, $result['code']);
         } catch (Exception $e) {
             Log::error('Exception: ' . $e->getMessage());
             return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
         }


    }

    public function edit(Request $request)
    {

        $bookId = $request->input('book_id');
        $data = $request->only(['titulo', 'descricao', 'imagem']);

        try {
            // Usa o serviço para atualizar o livro
            $result = $this->bookService->updateBook($data, $bookId);

            return response()->json($result, $result['code']);
        } catch (Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erro inesperado'], 500);
        }
    }

    public function favorite(Request $request)
    {
        $token = session('jwt_token');
        $bookId = $request->input('book_id');

        try {

            $result = $this->bookService->favoriteBook($token, $bookId);

            return response()->json($result, $result['code']);

        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());
            session()->forget('jwt_token');
            return redirect()->route('pagina.login');
            
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function unfavorite(Request $request)
    {

        $token = session('jwt_token');
        $bookId = $request->book_id;

        try {
            // Usa o serviço para desfavoritar o livro
            $result = $this->bookService->unfavoriteBook($token, $bookId);

            return response()->json($result, $result['code']);
        } catch (JWTException $e) {
            Log::error('JWTException: ' . $e->getMessage());
            session()->forget('jwt_token');
            return redirect()->route('pagina.login');
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {

        $token = session('jwt_token');
        $user = JWTAuth::setToken($token)->authenticate();

        try {
            $bookId = $request->book_id;

            // Usa o serviço para excluir o livro
            $result = $this->bookService->deleteBook($bookId);

            return response()->json($result, $result['code']);

        } catch (JWTException $e) {

            Log::error('JWTException: ' . $e->getMessage());
            session()->forget('jwt_token');
            return redirect()->route('pagina.login');

        } catch (Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);


        }
    }

    protected function ensureDirectoriesExist() // funcao que garante que os diretorios existam 
    {
        $directories = [
            'public/thumbnail',
        ];

        foreach ($directories as $directory) {

            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
        }
    }
}
