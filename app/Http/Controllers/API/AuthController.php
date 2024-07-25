<?php

namespace App\Http\Controllers\API;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            return $this->userService->login($credentials);
        } catch (\Exception $e) {
            Log::error('Lỗi người dùng đăng nhập: ' . $e->getMessage());
            return response()->json([
                'error' => 'Đăng nhập thất bại'
            ], 500);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        try {
            return $this->userService->register($data);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo mới người dùng: ' . $e->getMessage());
            return response()->json([
                'error' => 'Đăng ký thất bại'
            ], 500);
        }
    }

}
