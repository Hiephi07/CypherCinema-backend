<?php 

namespace App\Services\Theater;

use App\Repositories\Theater\TheaterRepositoryInterface;
use Exception;

class TheaterService {
    protected $theaterRepository;

    public function __construct(TheaterRepositoryInterface $theaterRepository)
    {
        $this->theaterRepository = $theaterRepository;
    }

    public function listTheater() {
        try {
            return $this->theaterRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách rạp: ' . $e->getMessage());
        }
    }

    public function theaterDetail($id) {
        try {
            return $this->theaterRepository->findById($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách rạp: ' . $e->getMessage());
        }
    }
}