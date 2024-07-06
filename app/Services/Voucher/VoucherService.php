<?php

namespace App\Services\Voucher;

use App\Repositories\Voucher\VoucherRepositoryInterface;
use Exception;

class VoucherService
{
    protected $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function validateVoucher(string $code)
    {
        try {
            return $this->voucherRepository->findValidVoucherByCode($code);
        } catch (Exception $e) {
            throw new Exception('Voucher không hợp lệ: '. $e->getMessage());
        }

    }
}
