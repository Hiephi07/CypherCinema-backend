<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function seats(Request $req) {
        try {
            
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'msg' => 'Lấy danh sách ghế không thành công'
                ]
            ], 500);
        }
    }
}
