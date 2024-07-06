<?php 

namespace App\Repositories\Theater;

use App\Models\Theater;
use Exception;

class TheaterRepository implements TheaterRepositoryInterface {
    protected $theater;

    public function __construct(Theater $theater)
    {
        $this->theater = $theater;
    }

    public function getAll()
    {
        try {
            return $this->theater->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả Theater: ' . $e->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            return $this->theater->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi không tìm thấy Theater: ' . $e->getMessage());
        }
    }
}