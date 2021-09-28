<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService as ServicesUserService;
use Illuminate\Http\Request;

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
         $result = false;
         $rules = [
             'email' => 'required|integer|min:1',
         ];
         $cust_mess = [
             'email.required' => 'Required Email of '.self::getTitle(),
         ];
         $this->validate($request,$rules,$cust_mess);
         $result = $this->validSendValuesRequest($request);
         if($result == false)
             return $this->service->update($id,$request);
         else
             return $result;
     }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function destroy($id)
     {
         return $this->service->destroy($id);
     }


}
