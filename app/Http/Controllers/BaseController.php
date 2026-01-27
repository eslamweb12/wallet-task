<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function successResponse($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function errorResponse($message = 'Error', $code = 400, $errors = [])
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }

    protected function successWithoutResponse( $message = 'Success', $code = 200){
        return response()->json([
                'status'  => true,
                'message' => $message,



            ]
            ,$code);
    }
}
