<?php

namespace App\Repositories\Voucher;

interface VoucherRepositoryInterface
{
    public function findValidVoucherByCode(string $code);
}
