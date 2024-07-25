<?php 

namespace App\Repositories\Paymentmethod;

use App\Models\PaymentMethod;
use Exception;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface {
    protected $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function getAll()
    {
        try {
            return $this->paymentMethod->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả Payment method: ' . $e->getMessage());
        }
    }
}