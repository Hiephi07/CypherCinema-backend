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

    public function listVoucher() {
        try {
            return $this->voucherRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách voucher ' . $e->getMessage());
        }
    }

    public function createVoucher($data) {
        try {
            return $this->voucherRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi tạo mới voucher ' . $e->getMessage());
        }
    }

    public function detailVoucher($id) {
        try {
            return $this->voucherRepository->getVoucherById($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy voucher theo id: ' . $e->getMessage());
        }
    }

    public function deleteVoucher($id) {
        try {
            return $this->voucherRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy voucher theo id: ' . $e->getMessage());
        }
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
