<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if(Token::where('token', $token)->exists()) {
            return $next($request);
            
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Token đã bị vô hiệu hóa'
            ]);
        }
        
    }
}
