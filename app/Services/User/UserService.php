<?php

namespace App\Services\User;

use App\Events\UserRegistered;
use App\Mail\VerifyEmail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Resources\User\UserProfileResource;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        try {
            $user = $this->userRepository->create($data);

            // event(new Registered($user));
            event(new UserRegistered($user));

            return response()->json([
                'status' => true,
                'data' => $user->email,
                'msg'  => "Đăng ký thành công, vui lòng kiểm tra email để lấy link xác minh."
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'errors' => [
                    'msg'  => $e->getMessage()//"Không thể tạo người dùng"
                ]
            ], 500);
        }
    }
    public function login( $credentials )
    {
        if ( !$token = Auth::attempt( $credentials ) ) {
            return response()->json([
                "status" => false,
                'error' => [
                    "msg" => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]
            ], 401);
        }

        try {
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return response()->json([
                "status" => false,
                'error' => [
                    "msg" => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]
            ], 500);
        }
    }


    public function profile( $authorization )
    {
        if(empty( $authorization )){
            return response()->json([
                "status" => false,
                "error" => [
                    'msg' => "Header Authorization trống!"
                ]
            ], 401);
        }

        try {
            // Lấy token
            $token = JWTAuth::getToken();
            // Giải mã Payload trong Token
            $payload = JWTAuth::getPayload($token)->toArray();
            // Lấy ID User
            $userID = $payload["sub"];

            $user = $this->userRepository->findById($userID);
            
            return new UserProfileResource($user);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                "error" => [
                    'msg' => "Đã có lỗi xảy ra!"
                ]
            ], 500);
        }
        
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'data' => [
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'expires_in'    => Auth::factory()->getTTL() // 1 hour
            ]
        ], 201);
    }
}
