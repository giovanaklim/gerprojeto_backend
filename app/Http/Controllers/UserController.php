<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->toArray())) {
            return response([
                'errors' => [
                    'auth' => ['Usuário ou senha inválidos.']
                ]
            ], 404);
        } else {
            return response(Auth::user(), 201);
        }
    }
}
