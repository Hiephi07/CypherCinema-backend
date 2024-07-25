<?php 

namespace App\Services\City;

use App\Repositories\City\CityRepositoryInterface;
use Exception;

class CityService {
    protected $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function listCity() {
        try {
            return $this->cityRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách city: ' . $e->getMessage());
        }
    }
}