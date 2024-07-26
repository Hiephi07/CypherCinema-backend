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
            throw new Exception('Lỗi tìm nạp tất cả theater: ' . $e->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            return $this->theater->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi không tìm thấy theater: ' . $e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return $this->theater->create($data);
        } catch (Exception $e) {
            throw new Exception('Lỗi không thể tạo mới theater: ' . $e->getMessage());
        }
    }

    public function update($data, $id)
    {
        
    }

    public function delete($id)
    {
        try {
            $theater = $this->theater->findOrFail($id);
            return $theater->delete();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy theater: ' . $e->getMessage());
        }
    }
}