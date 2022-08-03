<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StageController;
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

 Route::middleware('auth:sanctum')->group(function () {
    Route::get('/is-logged', [UserController::class, 'isLogged']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/showStages/{projectId}', [StageController::class, 'showStages']);
    Route::resource('team', TeamController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('stage', StageController::class);
});
