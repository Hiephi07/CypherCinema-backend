<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function getAll() {
        try {
            $method = PaymentMethod::get();
            return response()->json([
                'status' => true,
                'data' => $method,
                'msg' => 'Thành công'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thất bại'
            ], 404);
        }
    }
}
