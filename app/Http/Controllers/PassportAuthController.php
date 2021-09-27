<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    /**
     * Method Rgister User
     * Required: name, email, passwor, dni
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'dni' => 'required|min:8',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'dni' => $request->dni,
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;
        return response()->json([
            'token' => $token
        ],200);
    }

    /**
     * Metoho Login User
     */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            //'user_id' => $user->id,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);

    }
}
