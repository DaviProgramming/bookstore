<?php

namespace App\Services\Api;

use App\Repositories\Api\ApiAuthRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class ApiAuthService
{
    protected $apiAuthRepository;

    public function __construct(ApiAuthRepositoryInterface $apiAuthRepository)
    {
        $this->apiAuthRepository = $apiAuthRepository;
    }

    /**
     * Tenta autenticar um usuário e retorna um token JWT se for bem-sucedido.
     *
     * @param array $credentials
     * @return string|null
     */
    public function attemptLogin(array $credentials)
    {
        return $this->apiAuthRepository->attemptLogin($credentials);
    }

    public function registerUser(array $data)
    {
        // Hash da senha do usuário
        $data['password'] = Hash::make($data['password']);

        // Registro do usuário pelo repositório
        $user = $this->apiAuthRepository->registerUser($data);

        if ($user) {
            // Gera o token JWT para o novo usuário
            $token = JWTAuth::fromUser($user);

            return [
                'status' => 'success',
                'message' => 'Usuário registrado com sucesso!',
                'token' => $token,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Erro ao registrar o usuário.',
        ];
    }

    /**
     * Define o token JWT na sessão.
     *
     * @param string $token
     * @return void
     */
    public function setTokenInSession($token)
    {
        $this->apiAuthRepository->setTokenInSession($token);
    }

    /**
     * Recupera o token JWT da sessão.
     *
     * @return string|null
     */
    public function getTokenFromSession()
    {
        return $this->apiAuthRepository->getTokenFromSession();
    }

    /**
     * Atualiza o token JWT na sessão.
     *
     * @param string $token
     * @return string
     * @throws JWTException
     */
    public function refreshToken($token)
    {
        return $this->apiAuthRepository->refreshToken($token);
    }

    /**
     * Remove o token JWT da sessão.
     *
     * @return void
     */
    public function flushSession()
    {
        $this->apiAuthRepository->flushSession();
    }
}
