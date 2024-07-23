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

    public function getAll()
    {
        try {
            return $this->voucher->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả voucher: ' . $e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return $this->voucher->create($data);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi tạo voucher: ' . $e->getMessage());
        }
    }

    public function getVoucherById($id)
    {
        try {
            return $this->voucher->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy voucher: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $voucher = $this->voucher->findOrFail($id);
            return $voucher->delete();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy voucher: ' . $e->getMessage());
        }
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