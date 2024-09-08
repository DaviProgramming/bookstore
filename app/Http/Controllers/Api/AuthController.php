<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\AuthService;
use App\Services\UserService;

use App\Models\User;

class AuthController extends Controller
{

    protected $authService;
    protected $userService;


    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;

    }

    public function login(Request $request){

        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5',
            'email' => 'required|email  ',
        ]);

        if ($valida->fails()) {
            return response()->json(['status' => 'error', 'message' => $valida->errors()], 404);
        }

        $credentials = $request->only('email', 'password');

        try {

            $token = $this->authService->attemptLogin($credentials);

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos'], 401);
            }

            return response()->json(['status' => 'success', 'message' => 'Login realizado com sucesso!','token' => $token], 201);

        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Algum erro ocorreu, tente novamente.'], 500);
        }

    }

    public function store(Request $request){

        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($valida->fails()) {
            return response()->json(['status' => 'error', 'message' => $valida->errors()], 404);
        }

        $data = $request->only('email', 'name', 'password');

        $result = $this->userService->registerUser($data);

        if ($result['status'] === 'success') {

            return response()->json(['status' => 'success', 'message' => $result['message'], 'token' => $result['token']], 201);

        } else {
            return response()->json(['status' => $result['status'], 'message' => $result['message']], 404);
        }


    }

    public function refreshToken(Request $request){

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
        }

       try {
            $token = $request->bearerToken();

            $newToken = $this->authService->refreshToken($token);

            return response()->json(['status' => 'success', 'message' => 'Token atualizado com sucesso!', 'token' => $newToken]);

        } catch (JWTException $e) {
            Log::error('JWTException: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Não foi possível atualizar o token.'], 401);
        }
    }
}
