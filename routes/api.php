<?php

use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
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

Route::post('register', [PassportAuthController::class, 'register']);   //  Metodo para Registrar
Route::post('login', [PassportAuthController::class, 'login']); // Metodo para Iniciar Sesion

Route::middleware('auth:api')->group(function () {
    Route::resource('users', 'UserController',['only' => ['index','store','update','delete','show']]);
});