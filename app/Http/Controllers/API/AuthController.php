<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => $validator->errors(),
            ], 401);
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 0,
                'msg' => 'Thông tin đăng nhập không chính xác!'
            ], 401);
        }

        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }

    public function refresh(Request $req) {
        $token = $req->header('Authorization');
        try{
            $data = JWTAuth::getJWTProvider()->decode($token);
            $user = User::find($data['user_id']);
            if(!$user) {
                return response()->json(['error' => 'User không tồn tại' ], 404);
            } 
            $token = auth()->login($user);
            $refreshToken = $this->createRefreshToken();
            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e){
            return response()->json(['error' => 'Refresh Token không hợp lệ!'], 500);
        }
    }

    public function register(StorePostRequest $req) {
        // $validator = Validator::make($req->all(), [
        //     'email' => 'required|email|unique:users,email',
        //     'password' => [
        //         'required',
        //         'string',
        //         'min:8',
        //         'max:32',
        //         'regex:/[a-z]/', 
        //         'regex:/[A-Z]/',
        //         'regex:/[0-9]/', 
        //         'regex:/[@$!%*#?&]/', 
        //     ]
        // ], [
        //     'email.required' => 'Email là bắt buộc',
        //     'email.email' => 'Email không đúng định dạng',
        //     'email.unique' => 'Email đã tồn tại. Hãy thử lại với email khác!',
        //     'password.required' => 'Mật khẩu là bắt buộc.',
        //     'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
        //     'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        //     'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
        //     'password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái thường, một chữ cái hoa, một chữ số và một ký tự đặc biệt.'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 0,
        //         'msg' => $validator->errors(),
        //     ], 401);
        // }
        $validator = $req->validated();
        User::create([
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        return response()->json([
            'status' => 1,
            'msg' => 'Tạo mới user thành công',
        ], 201);
    }

    protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'status' => 1,
            'msg' => 'Đăng nhập thành công',
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    private function createRefreshToken() {
        $data = [
            'user_id' => auth()->user()->id,
            'random' => rand() + time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }

}
