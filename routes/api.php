<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/isLogged', function () {
        return Auth::user();
    });
    Route::get('/logout', function () {
        return Auth::guard('web')->logout();
    });

    Route::resource('team', TeamController::class);

    Route::resource('project', ProjectController::class);

    Route::get('project/get-stages/{id}', [ProjectController::class, 'getStages']);
// });
