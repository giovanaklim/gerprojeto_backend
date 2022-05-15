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
        $user = User::where('email', $request->email)->first();
        $attempt = Auth::attempt($request->toArray());

        if (!$user || !$attempt) {
            return response([
                'errors' => [
                    'auth' => ['Usuário ou senha inválidos.']
                ]
            ], 404);
        } else {
            return response($user, 201);
        }
    }
}
