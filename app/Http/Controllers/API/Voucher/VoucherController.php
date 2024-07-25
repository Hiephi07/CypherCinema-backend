<?php

namespace App\Http\Controllers\API\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\VoucherRequest;
use App\Http\Resources\Voucher\VoucherResource;
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

    public function listVoucher() {
        try {
            $vouchers = $this->voucherService->listVoucher();
            return VoucherResource::collection($vouchers)->additional([
                'status' => true,
                'msg' => 'Lấy danh sách voucher thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function createVoucher(VoucherRequest $req) {
        try {
            $voucher = $this->voucherService->createVoucher($req->all());
            return (new VoucherResource($voucher))->additional([
                'status' => true,
                'msg' => 'Thêm mới voucher thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function detailVoucher($id) {
        try {
            $voucher = $this->voucherService->detailVoucher($id);
            return (new VoucherResource($voucher))->additional([
                'status' => true,
                'msg' => 'Lấy voucher thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteVoucher($id) {
        try {
            $this->voucherService->deleteVoucher($id);
            return response()->json([
                'status' => true,
                'data' => null,
                'msg' => 'Voucher đã được xóa thành công'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
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
