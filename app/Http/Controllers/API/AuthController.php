<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $req)
    {
        $validator = $req->validated();

        if (!$token = JWTAuth::attempt($validator)) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thông tin đăng nhập không chính xác. Hãy thử lại'
            ], 401);
        }
        
        $refreshToken = $this->createRefreshToken();
        return $this->respondWithToken($token, $refreshToken);
    }

    public function refresh(Request $req) {
        try {
            $token = JWTAuth::parseToken()->refresh();
        } catch (JWTException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Không thể refresh token.'
            ], 401);
        }
        $refreshToken = $this->createRefreshToken();
        return $this->respondWithToken($token, $refreshToken);
    }

    public function register(StorePostRequest $req) {
        $validator = $req->validated();
        $user = User::create([
            'email' => $validator['email'],
            'password' => Hash::make($validator['password']),
            'full_name' => $validator['full_name'],
            'phone_number' => $validator['phone_number'],
            'sex' => $validator['sex'],
        ]);
        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ],
            'msg' => 'Tạo mới user thành công',
        ], 201);
    }

    protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'status' => true,
            'data' => [
                'user' => auth()->user(),
            ],
            'msg' => 'Đăng nhập thành công',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL(),
        ]);
    }

    public function me() {
        return response()->json(auth()->user());
    }

    private function createRefreshToken() {
        $expirationTime = Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->timestamp;

        $token = JWTAuth::customClaims(['exp' => $expirationTime])->fromUser(auth()->user());
        return $token;
    }

}
