<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    // Gửi email xác thực
    public function sendVerificationEmail(Request $request)
    {
        $user = auth()->user();

        // Kiểm tra thời gian để gửi Email
        $check = $this->canResendVerificationEmail($user);
        if (!$check['canResend']) {
            return response()->json([
                'message' => 'Vui lòng chờ ' . $check['remainingTime'] . ' giây trước khi yêu cầu email xác minh mới.'
            ], 429);
        }

        // Kiểm tra Email đã được xác minh chưa
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email đã được xác minh.'], 200);
        }

        // Gửi email xác minh
        $request->user()->sendEmailVerificationNotification();

        // Lưu thời gian gửi email vào cache
        Cache::put('email_verification_' . $user->id, now()->addMinutes(3)->timestamp, 180); // 180 giây = 3 phút

        return response()->json(['message' => 'Đã gửi Email xác minh.'], 200);
    }

    // Xác thực email
    public function verify(EmailVerificationRequest $request)
    {
        // Kiểm tra email đã được xác minh chưa?
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified(); // Đánh dấu Email đã được xác minh

            event(new Verified($request->user()));
        }

        return response()->json(['message' => 'Đã xác minh email thành công.'], 200);
    }

    // Kiểm tra thời gian gửi lại Email xác thực
    private function canResendVerificationEmail($user)
    {
        $cacheKey = 'email_verification_' . $user->id;
        
        if (Cache::has($cacheKey)) {
            // Tính toán thời gian còn lại để có thể gửi email xác minh mới
            $remainingTime = Cache::get($cacheKey) - now()->timestamp;
            return ['canResend' => false, 'remainingTime' => $remainingTime];
        }
        
        return ['canResend' => true];
    }
}
