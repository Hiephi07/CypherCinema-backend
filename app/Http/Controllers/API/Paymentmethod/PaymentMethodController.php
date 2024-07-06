<?php

namespace App\Http\Controllers\API\Paymentmethod;

use App\Http\Controllers\Controller;
use App\Http\Resources\Paymentmethod\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Services\Paymentmethod\PaymentMethodService;
use Exception;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    protected $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    public function getAll() {
        try {
            $data = $this->paymentMethodService->listPaymentMethod();
            return PaymentMethodResource::collection($data)->additional([
                'status' => true,
                'msg' => 'Thành công'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
