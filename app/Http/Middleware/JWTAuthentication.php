<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthentication {
    public function handle($request, Closure $next) {
        try {
            // Kiểm tra có hợp lệ không?
            if (!$token = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        'msg' => 'Không tìm thấy người dùng.'
                    ]
                ], 404);
            }
        } catch (TokenExpiredException $e) {

            // Nếu token đã hết hạn sẽ làm mới token
            try {
                $newToken = JWTAuth::refresh(JWTAuth::getToken());
                // Đặt token mới vào header
                $response = $next($request);
                $response->headers->set('Authorization', 'Bearer ' . $newToken);

                // Trả về token mới;
                return response()->json(['newToken' => $newToken], 201);
            } catch (JWTException $e) {
                return response()->json([
                        'status' => false,
                        'error' => 'Token đã hết hạn.'
                    ], 401);
            }
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Token không hợp lệ!'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Token không được cung cấp.'
            ], 401);
        }

        return $next($request);
    }
}
