<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->responseValidator($validator);
        }

        $username_type = filter_var($request->username, FILTER_VALIDATE_EMAIL) 
            ? "email" : "username";
        $attemp_user = [
            'password' => $request->password,
            $username_type => $request->username,
        ];

        if (! Auth::attempt($attemp_user)) {
            return $this->responseError(trans('auth.failed'));
        }

        $user = Auth::user();
        $user->tokens()->where('name', 'mobile_api')->delete();
        $token = $user->createToken('mobile_api')->plainTextToken;

        return $this->responseSuccess('Login Succefully', [
            'user' => $user,
            'token' => $token,
        ]);
    }
}
