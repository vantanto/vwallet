<?php
namespace App\Http\Traits;

trait ResponseTrait {

    public function responseSuccess($message = true, $data = null)
    {
        return response()->json([
            'status' => 'success',
            'msg' => $message,
            'data' => $data,
        ], 200);
    }

    public function responseError($message = true, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'msg' => $message,
            'data' => $data,
        ], 400);
    }

    public function responseValidator($validator)
    {
        return response()->json([
            'status' => 'validator',
            'msg' => 'Input Error',
            'data' => $validator->messages(),
        ], 422);
    }
}