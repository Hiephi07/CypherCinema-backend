<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function applyVoucher(Request $req) {
        try {
            $voucher = Voucher::where('name', $req->code)
                            ->where('status', 1)         
                            ->where('quantity', '>', 0)
                            ->where('expiration_date', '>', Carbon::now()->toDateString())       
                            ->first();
            if(!$voucher) {
                throw new Exception();
            }
            return response()->json([
                'status' => true,
                'data' => $voucher->name,
                'msg' => 'Mã hợp lệ'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'msg' => 'Mã không hợp lệ'
                ]
            ], 500);
        }
    }
}
