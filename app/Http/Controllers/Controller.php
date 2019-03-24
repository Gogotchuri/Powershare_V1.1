<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Wraps Data in json api format before return
     * not used with collections
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function responseData($data, int $statusCode = 200){
        return response()->json(["data" => $data], $statusCode);
    }

    /**
     * Wraps errors in json api format before return
     * Errors always be array in json, if user doesn't provide array we convert
     * @param $errors
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected static function responseErrors($errors, int $statusCode){
        if(!is_array($errors)) $errors = array($errors);
        return response()->json(["errors" => $errors], $statusCode);
    }
}
