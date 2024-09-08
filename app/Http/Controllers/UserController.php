<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    public function create(){

        $page = 'cadastro';

        return view('pages.cadastro')->with(['page' => $page]);

    }

    public function store(Request $request)
    {
        $valida = Validator::make($request->all(), [
            'password' => 'required|string|min:5',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($valida->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Dados inválidos'], 404);
        }

        $data = $request->only('email', 'name', 'password');

        $result = $this->userService->registerUser($data);

        if ($result['status'] === 'success') {
            session(['jwt_token' => $result['token']]);
            return response()->json(['status' => 'success', 'message' => $result['message'], 'token' => $result['token']], 201);
        } else {
            return response()->json(['status' => $result['status'], 'message' => $result['message']], 404);
        }
    }
}
