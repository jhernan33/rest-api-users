<?php

use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
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

//Route::get('users', [UserController::class,'index']);
Route::middleware('auth:api')->group(function () {
    Route::resource('users', UserController::class);
});


// Route::middleware('auth:api')->group(function () {
//     //Route::post('logout', [PassportAuthController::class, 'logout']);
//     Route::resource('users', UserController::class);
// });


// Route::middleware('auth:api')->group(function () {
//     //Route::resource('users', 'UserController',['only' => ['index','store','update','delete','show']]);
//     Route::resource('users', UserController::class);
//     //Route::get('logout', 'PassportAuthController@logout');
// });