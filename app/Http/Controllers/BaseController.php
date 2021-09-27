<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;
    public static $title;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Request|null $request
     */
    public function index(Request $request){
    }

    /**
     * @param $id
     */
    public function show($id){

    }

    /**
     * @param Request $request
     */
    public function store(Request $request){

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id){

    }

    /**
     * @param $id
     */
    public function destroy($id){

    }

    /**
     * @param $id
     */
    public function restore($id){

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
}
