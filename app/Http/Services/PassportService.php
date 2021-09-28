<?php


namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PassportService extends BaseService{
    
    /**
     * PassportService constructor.
     * @param $Title
     */
    public function __construct($Title)
    {
        parent::__construct($Title);
    }

    /**
     * @param Request|null $request
     */
    public function index(Request $request = null)
    {
        try {
            $pages = $request->has('pages') ? $request->pages : self::$pages;
            return $list = User::whereNull('deleted_at')
                ->orderBy('name','asc')
                ->paginate($pages)
                ;
        } catch (Exception $e) {
            return self::showMessageObject('Error Not Registered',500,$e->getMessage());
        }
    }

    /**
     * @param $id
     * @param Request|null $request
     */
    public function show($id, Request $request = null)
    {
        try {
            $list = User::whereNull('deleted_at')
                ->where('id','=',$id)
                ->get()
                ->toArray()
            ;
            if(count($list)>0){
                return $list;
            }else{
                return $this->showMessage('Not Registered',404);
            }
        } catch (Exception $e) {
            return self::showMessageObject('Error Not Registered',500,$e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function store(Request $request)
    {
        /**
         * Validar si esta Registrado el Email y DNI
         */
        $result_search = User::whereNull('deleted_at')
            ->where('email','=',self::convertText($request->email))
            ->where('dni','=',self::convertText($request->dni))
            ->get()
            ->toArray();
        if(count($result_search)>0){
            return $this->showMessage('Already Registered',200);
        }else{
            //  Realizar el Insert
            try{
                DB::beginTransaction();
                    /**
                     * Crear el usuario
                     */
                    $user = User::create([
                        'full_name' => $request->full_name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'dni' => $request->dni,
                    ]);

                    /**
                     * Validar el Rol si lo envian en el Request
                     */
                    $array_save_rol = [
                        'role_id' => $request->has('rol_id') ? $request->rol_id: 2,
                        'user_id' => $user->id,
                        'created_at' => $this->getStoreNow(),
                    ];

                    UserRole::whereNull('deleted_at')
                    ->where('rol_id','=',$request->rol_id)
                    ->where('user_id','=',$request->name)
                    ->insert($array_save_rol);
                DB::commit();
                    $token = $user->createToken('LaravelAuthApp')->accessToken;
                    return response()->json(['token' => $token],200);
                }catch (Exception $e){
                    DB::rollBack();
                    return self::showMessageObject('Error Not Registered',500,$e->getMessage());
                }
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function update($id, Request $request)
    {
        $array_image = []; $array_photo_mobile = [];
        $array_update = [
            'name' => self::convertText($request->name),
            'code' => self::convertText($request->code),
            'user_id' => $request->user_id,
            'updated_at' => $this->getStoreNow(),
        ];
        
        $result_search = User::whereNull('deleted_at')
            ->where('id','=',$id)
            ->get()
            ->toArray();
        if(count($result_search)<=0){
            return $this->showMessage('Not Registered',404);
        }else{
            //  Realizar el Insert
            $return = User::whereNull('deleted_at')
                ->where('id','=',$id)
                ->update($array_update);
        }
        if($return>0)
            return $this->showMessage('Updated successfully',200);
        else
            return $this->showMessage('Error',500);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object|void
     */
    public function destroy($id)
    {
        $array_save = [
            'deleted_at' => $this->getStoreNow(),
        ];
        $list = User::whereNull('deleted_at')
            ->where('id','=',$id)
            ->get()
            ->toArray()
        ;
        if(count($list)> 0){
            $result = User::whereNull('deleted_at')->where('id','=',$id)->update($array_save);
            return $result >0
                ? $this->showMessage('Successfully Deleted',200)
                : $this->showMessage('Error Deleted',500);
        }else{
            return $this->showMessage('Id Not Registered',404);
        }
    }

    /**
     * Metodo de Login
     */
    public function Login(Request $request){
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
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);

    }
}
?>