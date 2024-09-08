<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $data)
    {
        // Verifica se já existe um usuário com o mesmo email
        $existingUser = $this->userRepository->findByEmail($data['email']);

        if ($existingUser) {
            return ['status' => 'error', 'message' => 'O email já está em uso'];
        }

        // Cria um novo usuário
        $user = $this->userRepository->create($data);

        if ($user) {
            // Gera um token JWT para o usuário recém-criado
            try {
                $token = JWTAuth::attempt(['email' => $data['email'], 'password' => $data['password']]);
                if ($token) {
                    return ['status' => 'success', 'message' => 'Usuário criado!', 'token' => $token];
                } else {
                    return ['status' => 'error', 'message' => 'Usuário criado, mas falha ao gerar o token. Tente novamente.'];
                }
            } catch (JWTException $e) {
                return ['status' => 'error', 'message' => 'Erro ao gerar o token.'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Não foi possível criar o usuário'];
        }
    }
}
