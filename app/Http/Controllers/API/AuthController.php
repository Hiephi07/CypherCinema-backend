<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StorePostRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $req)
    {
        if (!$token = JWTAuth::attempt(request(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thông tin đăng nhập không chính xác. Hãy thử lại'
            ], 401);
        }
        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function refresh(Request $req)
    {
        try {
            $refreshToken = $req->bearerToken();
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
            if (isset($decode['sub'])) {
                Token::where('user_id', $decode['sub'])->delete();
            }
            $accessToken = JWTAuth::fromUser(auth()->user());
        } catch (JWTException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Không thể refresh token.'
            ], 401);
        }
        return $this->respondWithToken($accessToken, $refreshToken);
    }

    public function register(RegisterRequest $req)
    {
        $user = User::create([
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'full_name' => $req->full_name,
            'phone_number' => $req->phone_number,
            'sex' => $req->sex,
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
        Token::create([
            'token' => $token,
            'user_id' => auth()->user()->id
        ]);
        Token::create([
            'token' => $refreshToken,
            'user_id' => auth()->user()->id
        ]);
        return response()->json([
            'status' => true,
            'data' => [
                'user' => auth()->user()->email,
            ],
            'msg' => 'Đăng nhập thành công',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL(),
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    private function createRefreshToken()
    {
        $expirationTime = Carbon::now()->addMinutes(config('jwt.refresh_ttl'))->timestamp;

        $token = JWTAuth::customClaims(['exp' => $expirationTime])->fromUser(auth()->user());
        return $token;
    }

    public function logout(Request $req)
    {
        $token = $req->bearerToken();
        $decode = JWTAuth::getJWTProvider()->decode($token);
        if (isset($decode['sub'])) {
            Token::where('user_id', $decode['sub'])->delete();
        }

        if ($token) {
            return response()->json([
                'status' => true,
                'message' => 'Bạn đã đăng xuất thành công',
            ]);
        }
    }

    public function sendEmail(ForgotPasswordRequest $req)
    {
        if(User::where('email', $req->email)->exists()) {
            $token = Str::random(64);
            try {
                PasswordResetToken::create([
                    'email' => $req->email,
                    'token' => $token,
                    'created_at' => now()
                ]);
            } catch (QueryException $exception) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Email đã được gửi yêu cầu. Vui lòng kiểm tra lại!'
                ], 400);
            }
            Mail::to($req->email)->send(new ResetPasswordMail($token, $req->email));
    
            return response()->json([
                'status' => true,
                'msg' => 'Vui lòng kiểm tra email.'
            ], 200);

        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Email không tồn tại trên hệ thống'
            ]);
        }

    }

    public function resetPassword(ResetPasswordRequest $req) {
        $email = $req->email;
        $token = $req->token;
        $password = $req->password;
        
        $resetPassword = PasswordResetToken::where('email', $email)->where('token', $token)->first();

        if (!$resetPassword) {
            return response()->json([
                'status' => false,
                'msg' => 'Thông tin đặt lại mật khẩu không hợp lệ.'
            ], 400);
        }
    
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'msg' => 'Người dùng không tồn tại.'
            ], 404);
        }
    
        $user->password = Hash::make($password);
        $user->save();
    
        PasswordResetToken::where('email', $email)->delete();
    
        return response()->json([
            'status' => true,
            'msg' => 'Mật khẩu đã được đặt lại thành công.'
        ]);
    }
}
