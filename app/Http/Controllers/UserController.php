<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiExceptionManager;
use App\Facades\Response;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $user= User::where('email', $request->email)->first();
            $attempt = Auth::attempt($request->toArray());
            if (!$user || !$attempt) {
                throw new Exception("Usuário ou senha inválidos.");
            } else {
                $token = $user->createToken('my-app-token')->plainTextToken;
                $response = [
                    'user'      => $user,
                    'token'     => $token
                ];
            }

            DB::commit();
            return response($response,\Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Exception $th) {
            DB::rollBack();
            return ApiExceptionManager::handleException($th, 422,'Erro ao fazer login.');
        }
    }

    public function isLogged()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return response($user, \Illuminate\Http\Response::HTTP_OK, ['success']);
            } else {
                return response(['error' => 'Unauthenticated'], \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Throwable $th) {
            return ApiExceptionManager::handleException($th, func_get_args(), 'user not authenticated');
        }
    }

    public function logout()
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            DB::commit();
            return response([],\Illuminate\Http\Response::HTTP_OK, ['success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiExceptionManager::handleException($th, func_get_args(), 'user delete error');
        }
    }

    public function register (Request $request)
    {
        try {
            DB::beginTransaction();
            $response = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' =>  $request->email
            ]);
            DB::commit();
            return \App\Helpers\Response::getJsonResponse  ('success', $response, 201);
        }catch (\Exception $e){
            DB::rollBack();
            return ApiExceptionManager::handleException($e, func_get_args());
        }

    }

}



