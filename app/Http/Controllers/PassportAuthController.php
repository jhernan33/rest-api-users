<?php

namespace App\Http\Controllers;

use App\Http\Services\PassportService;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UserRole;

class PassportAuthController extends BaseController
{

    /**
     * Method Constructor
     */
    public function __construct()
    {
        self::setTitle("User");
        $this->service = new PassportService(self::getTitle());
    }

    /**
     * Method Rgister User
     * Required: name, email, passwor, dni
     */
    public function register(Request $request)
    {
        /**
         * Validar los datos del Request
         */
        $this->validate($request, [
            'full_name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'dni' => 'required|min:7',
            'date_of_birth' => 'date_format:Y-m-d',
        ]);

        /**
         * Llamar al metodo del Service de Guardar
         */
        return $this->service->store($request);
    }

    /**
     * Metodo de Login Usuario
     */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        
        return $this->service->Login($request);
    }

    /**
     * Metodo Para Cerrar la Sesion del Usuario
     */
    public function logout(Request $request)
    {
        return "Ingreso Cerrado Login";
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
