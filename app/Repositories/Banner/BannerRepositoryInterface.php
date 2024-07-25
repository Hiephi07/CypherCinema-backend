<?php 

namespace App\Repositories\Banner;

interface BannerRepositoryInterface {
    public function getAll();
    public function getBannerById($id);
    public function create($data);
    public function delete($id);
    public function getByType($type);
}