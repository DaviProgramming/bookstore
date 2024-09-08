<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
