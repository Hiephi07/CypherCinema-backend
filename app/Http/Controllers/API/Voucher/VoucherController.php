<?php

namespace App\Http\Controllers\API\Voucher;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Services\Voucher\VoucherService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function applyVoucher(Request $req) {
        try {
            $voucher = $this->voucherService->validateVoucher($req->code);

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
