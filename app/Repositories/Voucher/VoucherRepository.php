<?php

namespace App\Repositories\Voucher;

use App\Models\Voucher;
use Carbon\Carbon;
use Exception;

class VoucherRepository implements VoucherRepositoryInterface
{
    protected $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    public function findValidVoucherByCode(string $code)
    {
        try {
            return $this->voucher->where('name', $code)
                            ->where('status', 1)
                            ->where('quantity', '>', 0)
                            ->where('expiration_date', '>', Carbon::now()->toDateString())
                            ->first();
        } catch (Exception $e) {
            throw new Exception('Mã code không tồn tại. '. $e->getMessage());
        }
    }
}