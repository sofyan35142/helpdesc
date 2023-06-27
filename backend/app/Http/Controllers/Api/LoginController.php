<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // return "p";
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        //res validator
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        //credentiasl for login
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        //if login success
        if (!$token) {
            return response()->json([
                "success" => false,
                "message" => "email atau password anda salah"
            ],401);
        }

        //auth success
        return response()->json([
            'success' => true,
            'dataUser' => auth()->user(),
            'token' => $token,
        ],200);
    }
}
