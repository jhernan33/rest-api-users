<?php


namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseService
{
    public static $title;
    public static $pages = 0;


    public function __construct($Title)
    {
        self::setTitle($Title);
        self::$pages =5;
    }

    /**
     * @param Request|null $request
     */
    public function index(Request $request = null)
    {
        $list = []; $columns = [];
        // TODO: Implement index() method.
    }


    /**
     * @param $id
     * @param Request|null $request
     */
    public function show($id, Request $request = null)
    {
        $list = [];
        // TODO: Implement show() method.
    }


    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $array_save = []; $result_search = []; $return = null;
        // TODO: Implement store() method.
    }


    /**
     * @param $id
     * @param Request $request
     */
    public function update($id, Request $request)
    {
        $array_update = []; $result_search = []; $return = null;
        // TODO: Implement update() method.
    }


    /**
     * @param $id
     */
    public function destroy($id)
    {
        $array_save =[];
        // TODO: Implement deleted() method.
    }


    /**
     * @param $mensaje
     * @param $code
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function showMessage($mensaje, $code){
        return response()->json([
            'status' => $code,
            'message' =>self::getTitle().' '.$mensaje
        ], $code)->setStatusCode($code);
    }


    /**
     * @param $mensaje
     * @param $code
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function showMessageId($mensaje, $code, $id){
        return response()->json([
            'status' => $code,
            'message' =>$mensaje,
            'id' => $id
        ], $code)->setStatusCode($code);
    }

    /**
     * @param $mensaje
     * @param $code
     * @param null $object
     * @return \Illuminate\Http\JsonResponse|object
     */
    public static function showMessageObject($mensaje, $code, $object = null){
        return response()->json([
            'status' => $code,
            'message' =>$mensaje,
            'result' => $object
        ], $code)->setStatusCode($code);
    }


    public function getQuery(Builder $cadena){
        $sql = str_replace('?', "'?'", $cadena->toSql());
        return vsprintf(str_replace('?', '%s', $sql), $cadena->getBindings());
    }

    /**
     * @return string
     */
    public function getStoreNow(){
        return Carbon::now('UTC')->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getNow(){
        $app = 'null';
        $app = explode(',',config('app.timezone'))[0];
        return Carbon::now('UTC')->setTimezone($app)->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function getDate(){
        $app = null;
        $app = explode(',',config('app.timezone'))[0];
        return Carbon::now('UTC')->setTimezone($app)->format('Y-m-d');
    }

    /**
     * @return string
     */
    public static function getNowDateTime(){
        $app = explode(',',config('app.timezone'))[0];
        return Carbon::now('UTC')->setTimezone($app)->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public static function getTitle()
    {
        return self::$title;
    }

    /**
     * @param mixed $title
     */
    public static function setTitle($title): void
    {
        self::$title = $title;
    }

    /**
     * @param $value
     * @return string
     */
    public static function formatNumeric($value){
        return  floatval(number_format($value,env('DB_NUMERIC_DECIMALS'),env('DB_NUMERIC_DECIMALS_POINT'),''));
    }

    /**
     * @param $model
     * @param $id
     * @return mixed
     */
    public static function searchValueGeneral($model, $id){
        $result = [];
        $result = $model::whereNull('deleted_at')
            ->where('id','=',$id)
            ->get()
        ;
        return $result;
    }

    public static function convertText($value){
        return strtolower(trim($value));
    }

    public static function getDateTimeToUtc($dateTime){
        return isset($dateTime) ? Carbon::parse($dateTime,'UTC')->setTimezone('America/Caracas')->format('Y-m-d H:i:s') : '';
    }
}
