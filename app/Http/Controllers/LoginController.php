<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\AuthService;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        $page = 'login';
        return view('pages.login')->with(['page' => $page]);
    }

    public function login(Request $request)
    {
        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5',
            'email' => 'required|email',
        ]);

        if ($valida->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Dados inválidos'], 404);
        }

        $credentials = $request->only('email', 'password');

        try {
            $token = $this->authService->attemptLogin($credentials);

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos'], 401);
            }

            if (!session()->isStarted()) {
                session()->start();
            }

            $this->authService->setTokenInSession($token);

            return response()->json(['status' => 'success', 'message' => 'Login realizado com sucesso!'], 201);

        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Algum erro ocorreu, tente novamente.'], 500);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->flushSession();
        return redirect()->route('pagina.login');
    }

    public function refresh(Request $request)
    {
        try {
            $token = $this->authService->getTokenFromSession();
            $newToken = $this->authService->refreshToken($token);
            $this->authService->setTokenInSession($newToken);

            return response()->json(['status' => 'success', 'message' => 'Token atualizado com sucesso!']);

        } catch (JWTException $e) {
            Log::error('JWTException: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Não foi possível atualizar o token.'], 401);
        }
    }
}
