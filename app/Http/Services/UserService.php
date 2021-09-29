<?php


namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole as ModelsUserRole;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UserRole;

class UserService extends BaseService{
    
    /**
     * UserService constructor.
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
            $list = User::whereNull('deleted_at')
                ->orderBy('full_name','asc')
                ->paginate($pages)
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
     * @param $id
     * @param Request|null $request
     */
    public function show($id, Request $request = null)
    {
        try {
            $list = User::whereNull('deleted_at')
                ->where('id','=',$id)
                ->with('role')
                ->get()
            ;
            if(count($list)>0){
                /**
                 * Buscar el Detalle de Rol y sus Permisos
                 */
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
        $array_save = [
            'name' => self::convertText($request->name),
            'code' => self::convertText($request->code),
            'user_id' => $request->user_id,
            'created_at' => $this->getStoreNow(),
        ];
        $result_search = User::whereNull('deleted_at')
            ->where('code','=',self::convertText($request->code))
            ->where('name','=',self::convertText($request->name))
            ->get()
            ->toArray();
        if(count($result_search)>0){
            return self::showMessageObject('Already Registered',200,$result_search);
        }else{
            //  Realizar el Insert
            try{
                DB::beginTransaction();
                $return = User::whereNull('deleted_at')
                    ->where('code','=',self::convertText($request->code))
                    ->where('name','=',self::convertText($request->name))
                    ->insertGetId($array_save);
                DB::commit();
                $return = self::searchValueGeneral(User::class,$return);
                return self::showMessageObject('created successfully',201,$return);
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
        $rol_id = 0;
        /**
         * Verificar el Rol del Usuario
         */
        $user = Auth::user()->id;
        $rol = new User();
        $rol_id = $rol->TipoRole($user);

        /**
         * Delete Permissions of Role
         */
        try{
            DB::beginTransaction();
                RolePermission::whereNull('deleted_at')
                ->where('role_id','=',$rol_id)
                ->delete();

                /**
                 * Array of Permissions
                 */
                foreach($request->permission as $value){
                    $array_save = [
                        'role_id' => $rol_id,
                        'permission_id' => $value['id'],
                        'created_at' => $this->getStoreNow(),
                    ];
                    //dd($array_save);
                    RolePermission::whereNull('deleted_at')
                    ->where('role_id','=',$rol_id)
                    ->insert($array_save);
                }
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return self::showMessageObject('Error Not Registered',500,$e->getMessage());
        }

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
}
?>