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
use App\Services\Api\ApiAuthService;

use App\Models\User;
use Exception;

class AuthController extends Controller
{

    protected $apiAuthService;

    public function __construct(ApiAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
    }

    public function login(Request $request)
    {
        // Valida as credenciais fornecidas
        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5',
            'email' => 'required|email',
        ]);

        if ($valida->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Dados inválidos'], 404);
        }

        $credentials = $request->only('email', 'password');

        try {
            // Tenta fazer login
            $token = $this->apiAuthService->attemptLogin($credentials);

            if (!$token) {
                return response()->json(['status' => 'error', 'message' => 'E-mail ou senha incorretos'], 401);
            }

            // Armazena o token na sessão
            $this->apiAuthService->setTokenInSession($token);

            return response()->json(['status' => 'success', 'message' => 'Login realizado com sucesso!', 'token' => $token], 201);

        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Algum erro ocorreu, tente novamente.'], 500);
        }
    }

    /**
     * Cria um novo usuário.
     */
    public function store(Request $request)
    {

        try{
            
            $valida = Validator::make($request->all(), [
                'password' => 'required|string|min:5',
                'name' => 'required|string',
                'email' => 'required|email',
            ]);
    
            if ($valida->fails()) {
                return response()->json(['status' => 'error', 'message' => 'Dados inválidos'], 404);
            }
    
            // Coleta os dados necessários para o registro
            $data = $request->only('email', 'name', 'password');
    
            // Registra o usuário
            $result = $this->apiAuthService->registerUser($data);
    
            if ($result['status'] === 'success') {
                return response()->json(['status' => 'success', 'message' => $result['message'], 'token' => $result['token']], 201);
            } else {
                return response()->json(['status' => $result['status'], 'message' => $result['message']], 404);
            }

        }catch(Exception $e){


                return response()->json(['status' => 'error' , 'message' => $e->getMessage()], 404);

        }
        // Valida os dados fornecidos
       
    }

    /**
     * Atualiza o token JWT.
     */
    public function refreshToken(Request $request)
    {
        // Obtém o token atual do cabeçalho da requisição
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token não fornecido'], 401);
        }

        try {
            // Atualiza o token
            $newToken = $this->apiAuthService->refreshToken($token);

            return response()->json(['status' => 'success', 'message' => 'Token atualizado com sucesso!', 'token' => $newToken]);

        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Não foi possível atualizar o token.'], 401);
        }
    }

    /**
     * Faz o logout do usuário e remove o token da sessão.
     */
    public function logout(Request $request)
    {
        $this->apiAuthService->flushSession();
        return response()->json(['status' => 'success', 'message' => 'Logout realizado com sucesso!']);
    }

   
}
