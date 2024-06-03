<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/[a-z]/', 
                'regex:/[A-Z]/',
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/', 
            ]
        ], [
            'email.unique' => 'Email đã tồn tại. Hãy thử lại với email khác!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => $validator->errors(),
            ], 400);
        }

        try {
            $user = User::create([
                'email' => $req->input('email'),
                'password' => Hash::make($req->input('password')),
            ]);

            return response()->json([
                'status' => 1,
                'msg' => 'Tạo mới user thành công',
            ], 201);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Email đã tồn tại. Hãy thử lại với email khác!',
                ], 401);
            }

            return response()->json([
                'status' => 0,
                'msg' => 'Có lỗi xảy ra. Vui lòng thử lại sau!',
            ], 500);
        }
    }
}
