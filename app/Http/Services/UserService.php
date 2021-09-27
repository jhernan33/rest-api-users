<?php

use App\Http\Services\BaseService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
?>