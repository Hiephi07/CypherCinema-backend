<?php 

namespace App\Services\Paymentmethod;

use App\Repositories\Paymentmethod\PaymentMethodRepositoryInterface;
use Exception;

class PaymentMethodService {
    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function listPaymentMethod() {
        try {
            return $this->paymentMethodRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách payment method: '. $e->getMessage());
        }
    }
}