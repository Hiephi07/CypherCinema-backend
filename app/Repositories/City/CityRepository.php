<?php 

namespace App\Repositories\City;

use App\Models\City;
use Exception;

class CityRepository implements CityRepositoryInterface {
    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getAll() {
        try {
            return $this->city->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả city: ' . $e->getMessage());
        }
    }
}