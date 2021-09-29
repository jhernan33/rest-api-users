<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService as ServicesUserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct()
    {
        self::setTitle("Users ");
        $this->service = new ServicesUserService(self::getTitle());
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
     {
        return $this->service->index($request);
     }

    /**
     * @param $id
     */
    public function show($id)
     {
         return $this->service->show($id);
     }

    /**
     * @param Request $request
     * @return string|void
     */
    public function store(Request $request)
     {
         $result = false;
         $rules = [
             'email' => 'required|email|unique:users,email',
         ];
         $cust_mess = [
             'email.required' => 'Required Email of '.self::getTitle(),
         ];
         $this->validate($request,$rules,$cust_mess);
         $result = $this->validSendValuesRequest($request);
         if($result == false)
             return $this->service->store($request);
         else
             return $result;

     }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function update(Request $request, $id)
     {
         //return "Update=>".$request;
         $result = false;
         $rules = [
             'permission' => 'required',
         ];
         $cust_mess = [
             'permission.required' => 'Required Permission of '.self::getTitle(),
         ];
         $this->validate($request,$rules,$cust_mess);
         
         return $this->service->update($id,$request);
     }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function destroy($id, Request $request)
     {
         /**
          * Validar si es un rol Administrador pueda eliminar
          */
          $user = Auth::user()->id;
          $rol = new User();
          return $rol->TipoRole($user)==1 ? $this->service->destroy($id) : $this->showMessage('Not Registered',404);
     }
}