<?php

namespace App\Repositories\Voucher;

interface VoucherRepositoryInterface
{
    public function getAll();
    public function create($data);
    public function getVoucherById($id);
    public function findValidVoucherByCode(string $code);
    public function delete($id);
}
